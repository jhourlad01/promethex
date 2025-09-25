const winston = require('winston');
const path = require('path');

// Create logs directory if it doesn't exist
const fs = require('fs');
const logsDir = path.join(__dirname, '../logs');
if (!fs.existsSync(logsDir)) {
    fs.mkdirSync(logsDir, { recursive: true });
}

// Define log format
const logFormat = winston.format.combine(
    winston.format.timestamp({
        format: 'YYYY-MM-DD HH:mm:ss'
    }),
    winston.format.errors({ stack: true }),
    winston.format.printf(({ timestamp, level, message, stack }) => {
        return `${timestamp} [${level.toUpperCase()}]: ${message}${stack ? '\n' + stack : ''}`;
    })
);

// Create logger instance
const logger = winston.createLogger({
    level: 'info',
    format: logFormat,
    transports: [
        // Console transport
        new winston.transports.Console({
            format: winston.format.combine(
                winston.format.colorize(),
                logFormat
            )
        }),
        
        // File transport for all logs
        new winston.transports.File({
            filename: path.join(logsDir, 'app.log'),
            maxsize: 5242880, // 5MB
            maxFiles: 5
        }),
        
        // File transport for errors only
        new winston.transports.File({
            filename: path.join(logsDir, 'error.log'),
            level: 'error',
            maxsize: 5242880, // 5MB
            maxFiles: 5
        })
    ]
});

// Add request logging middleware
logger.logRequest = (req, res, next) => {
    const start = Date.now();
    
    res.on('finish', () => {
        const duration = Date.now() - start;
        const logData = {
            method: req.method,
            url: req.url,
            status: res.statusCode,
            duration: `${duration}ms`,
            userAgent: req.get('User-Agent') || 'Unknown',
            ip: req.ip || req.connection.remoteAddress
        };
        
        if (res.statusCode >= 400) {
            logger.error(`HTTP ${res.statusCode} ${req.method} ${req.url} - ${duration}ms`, logData);
        } else {
            logger.info(`HTTP ${res.statusCode} ${req.method} ${req.url} - ${duration}ms`, logData);
        }
    });
    
    if (next) next();
};

// Add GraphQL error logging
logger.logGraphQLError = (error, context) => {
    const errorData = {
        message: error.message,
        locations: error.locations,
        path: error.path,
        extensions: error.extensions,
        context: context
    };
    
    logger.error('GraphQL Error', errorData);
};

module.exports = logger;

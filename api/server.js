const { ApolloServer } = require('apollo-server-express');
const express = require('express');
const cors = require('cors');
const jwt = require('jsonwebtoken');
require('dotenv').config();

const typeDefs = require('./schema/typeDefs');
const resolvers = require('./resolvers');
const db = require('./config/database');
const logger = require('./config/logger');

async function startServer() {
  const app = express();
  
  // Enable CORS
  app.use(cors());
  
  // Add request logging middleware
  app.use(logger.logRequest);
  
  // Create Apollo Server
  const server = new ApolloServer({
    typeDefs,
    resolvers,
    context: ({ req }) => {
      // Extract user from JWT token
      let user = null;
      const authHeader = req.headers.authorization;
      
      if (authHeader && authHeader.startsWith('Bearer ')) {
        const token = authHeader.substring(7);
        try {
          user = jwt.verify(token, process.env.JWT_SECRET || 'your-secret-key');
        } catch (error) {
          logger.warning('Invalid JWT token:', error.message);
        }
      }
      
      return {
        db,
        req,
        logger,
        user
      };
    },
    introspection: true,
    playground: true,
    formatError: (error) => {
      // Log GraphQL errors
      logger.logGraphQLError(error, {
        timestamp: new Date().toISOString()
      });
      
      // Return sanitized error for client
      return {
        message: error.message,
        locations: error.locations,
        path: error.path
      };
    }
  });
  
  await server.start();
  server.applyMiddleware({ app, path: '/' });
  
  const PORT = process.env.PORT || 4000;
  
  app.listen(PORT, () => {
    logger.info(`GraphQL API Server running at http://localhost:${PORT}`);
    logger.info(`GraphQL Playground available at http://localhost:${PORT}`);
    logger.info('Database connected successfully');
  });
}

startServer().catch(error => {
  logger.error('Error starting server:', error);
});

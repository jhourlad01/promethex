const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');
const crypto = require('crypto');
const emailService = require('../services/emailService');

const Mutation = {
  // Auth mutations
  async register(parent, { name, email, password }, { db }) {
    // Check if user already exists
    const [existingUsers] = await db.execute('SELECT id FROM users WHERE email = ?', [email]);
    
    if (existingUsers.length > 0) {
      throw new Error('User with this email already exists');
    }
    
    // Hash password
    const saltRounds = 12;
    const hashedPassword = await bcrypt.hash(password, saltRounds);
    
    // Generate email verification token
    const verificationToken = crypto.randomBytes(32).toString('hex');
    
    // Create user
    const [result] = await db.execute(
      'INSERT INTO users (name, email, password, email_verification_token, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
      [name, email, hashedPassword, verificationToken]
    );
    
    // Get the created user
    const [users] = await db.execute('SELECT id, name, email, email_verification_token, created_at FROM users WHERE id = ?', [result.insertId]);
    const user = users[0];
    
    // Send verification email
    try {
      await emailService.sendVerificationEmail(user.email, user.name, verificationToken);
    } catch (emailError) {
      console.error('Failed to send verification email:', emailError);
      // Don't throw error here - user is created successfully, just email failed
    }
    
    return {
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        email_verification_token: user.email_verification_token,
        created_at: user.created_at
      },
      message: 'Registration successful. Please check your email to verify your account.'
    };
  },

  async verifyEmail(parent, { token }, { db }) {
    // Find user by verification token
    const [users] = await db.execute('SELECT * FROM users WHERE email_verification_token = ?', [token]);
    
    if (users.length === 0) {
      throw new Error('Invalid verification token');
    }
    
    const user = users[0];
    
    // Check if already verified
    if (user.email_verified_at) {
      throw new Error('Email already verified');
    }
    
    // Update user to mark email as verified
    await db.execute(
      'UPDATE users SET email_verified_at = NOW(), email_verification_token = NULL WHERE id = ?',
      [user.id]
    );
    
    // Generate JWT token for immediate login
    const jwtToken = jwt.sign(
      { 
        id: user.id, 
        email: user.email,
        name: user.name 
      },
      process.env.JWT_SECRET || 'your-secret-key',
      { 
        expiresIn: '24h' 
      }
    );
    
    return {
      token: jwtToken,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        email_verified_at: new Date().toISOString(),
        created_at: user.created_at
      },
      message: 'Email verified successfully! You are now logged in.'
    };
  },

  async login(parent, { email, password, remember }, { db }) {
    // Find user by email
    const [users] = await db.execute('SELECT * FROM users WHERE email = ?', [email]);
    
    if (users.length === 0) {
      throw new Error('Invalid credentials');
    }
    
    const user = users[0];
    
    // Verify password
    const isValidPassword = await bcrypt.compare(password, user.password);
    
    if (!isValidPassword) {
      throw new Error('Invalid credentials');
    }
    
    // Generate JWT token
    const token = jwt.sign(
      { 
        id: user.id, 
        email: user.email,
        name: user.name 
      },
      process.env.JWT_SECRET || 'your-secret-key',
      { 
        expiresIn: remember ? '30d' : '24h' 
      }
    );
    
    return token;
  },

  async logout(parent, args, { db }) {
    // In a real implementation, you might want to blacklist the token
    // For now, we'll just return true
    return true;
  }
};

module.exports = Mutation;

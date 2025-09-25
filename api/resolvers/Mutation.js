const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');

const Mutation = {
  // Auth mutations
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

const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');

const Mutation = {
  // Review mutations
  async createReview(parent, { product_id, user_id, rating, title, comment, is_verified_purchase }, { db }) {
    // Check if user already reviewed this product
    const [existingReview] = await db.execute(
      'SELECT id FROM reviews WHERE product_id = ? AND user_id = ?',
      [product_id, user_id]
    );
    
    if (existingReview.length > 0) {
      throw new Error('User has already reviewed this product');
    }
    
    // Validate rating
    if (rating < 1 || rating > 5) {
      throw new Error('Rating must be between 1 and 5');
    }
    
    const [result] = await db.execute(
      `INSERT INTO reviews (product_id, user_id, rating, title, comment, is_verified_purchase, is_approved, helpful_votes, helpful_count, created_at, updated_at) 
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())`,
      [product_id, user_id, rating, title, comment, is_verified_purchase || false, true, 0, 0]
    );
    
    const [newReview] = await db.execute('SELECT * FROM reviews WHERE id = ?', [result.insertId]);
    return newReview[0];
  },

  async updateReview(parent, { id, rating, title, comment }, { db }) {
    const updateFields = [];
    const params = [];
    
    if (rating !== undefined) {
      if (rating < 1 || rating > 5) {
        throw new Error('Rating must be between 1 and 5');
      }
      updateFields.push('rating = ?');
      params.push(rating);
    }
    
    if (title !== undefined) {
      updateFields.push('title = ?');
      params.push(title);
    }
    
    if (comment !== undefined) {
      updateFields.push('comment = ?');
      params.push(comment);
    }
    
    if (updateFields.length === 0) {
      throw new Error('No fields to update');
    }
    
    updateFields.push('updated_at = NOW()');
    params.push(id);
    
    await db.execute(
      `UPDATE reviews SET ${updateFields.join(', ')} WHERE id = ?`,
      params
    );
    
    const [updatedReview] = await db.execute('SELECT * FROM reviews WHERE id = ?', [id]);
    return updatedReview[0];
  },

  async deleteReview(parent, { id }, { db }) {
    const [result] = await db.execute('DELETE FROM reviews WHERE id = ?', [id]);
    return result.affectedRows > 0;
  },

  async markReviewHelpful(parent, { id }, { db }) {
    const [result] = await db.execute(
      'UPDATE reviews SET helpful_votes = helpful_votes + 1, helpful_count = helpful_count + 1 WHERE id = ?',
      [id]
    );
    
    if (result.affectedRows === 0) {
      throw new Error('Review not found');
    }
    
    const [updatedReview] = await db.execute('SELECT * FROM reviews WHERE id = ?', [id]);
    return updatedReview[0];
  },

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

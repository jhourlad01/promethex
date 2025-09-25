const Review = {
  async product(parent, args, { db }) {
    if (!parent.product_id) return null;
    
    const [rows] = await db.execute('SELECT * FROM products WHERE id = ?', [parent.product_id]);
    return rows[0] || null;
  },

  async user(parent, args, { db }) {
    if (!parent.user_id) return null;
    
    const [rows] = await db.execute('SELECT id, name, email, email_verified_at, created_at, updated_at FROM users WHERE id = ?', [parent.user_id]);
    return rows[0] || null;
  },

  helpful_votes(parent) {
    // Ensure helpful_votes is always an integer
    if (parent.helpful_votes === null || parent.helpful_votes === undefined) {
      return 0;
    }
    return parseInt(parent.helpful_votes) || 0;
  },

  helpful_count(parent) {
    // Ensure helpful_count is always an integer
    if (parent.helpful_count === null || parent.helpful_count === undefined) {
      return 0;
    }
    return parseInt(parent.helpful_count) || 0;
  }
};

module.exports = Review;

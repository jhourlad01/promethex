const Product = {
  async category(parent, args, { db }) {
    if (!parent.category_id) return null;
    
    const [rows] = await db.execute('SELECT * FROM categories WHERE id = ?', [parent.category_id]);
    return rows[0] || null;
  },

  async reviews(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT * FROM reviews WHERE product_id = ? AND is_approved = true ORDER BY created_at DESC',
      [parent.id]
    );
    return rows;
  },

  async average_rating(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ? AND is_approved = true',
      [parent.id]
    );
    return rows[0].avg_rating ? parseFloat(rows[0].avg_rating) : 0;
  },

  async total_reviews(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT COUNT(*) as total FROM reviews WHERE product_id = ? AND is_approved = true',
      [parent.id]
    );
    return parseInt(rows[0].total) || 0;
  },

  primary_image(parent) {
    let images = parent.images;
    
    // Parse JSON string if it's a string
    if (typeof images === 'string') {
      try {
        images = JSON.parse(images);
      } catch (e) {
        return null;
      }
    }
    
    if (images && Array.isArray(images)) {
      return images[0] || null;
    }
    return null;
  },

  images(parent) {
    let images = parent.images;
    
    // Parse JSON string if it's a string
    if (typeof images === 'string') {
      try {
        images = JSON.parse(images);
      } catch (e) {
        return [];
      }
    }
    
    if (images && Array.isArray(images)) {
      return images;
    }
    return [];
  },

  stock_quantity(parent) {
    // Ensure stock_quantity is always an integer
    if (parent.stock_quantity === null || parent.stock_quantity === undefined) {
      return 0;
    }
    return parseInt(parent.stock_quantity) || 0;
  }
};

module.exports = Product;

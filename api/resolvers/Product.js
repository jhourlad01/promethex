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
    return rows[0].total;
  },

  primary_image(parent) {
    if (parent.images && Array.isArray(parent.images)) {
      return parent.images[0] || null;
    }
    return parent.image_url || null;
  },

  images(parent) {
    if (parent.images && Array.isArray(parent.images)) {
      return parent.images;
    }
    // Fallback to individual image fields
    const images = [];
    if (parent.image_url) images.push(parent.image_url);
    if (parent.image_url_2) images.push(parent.image_url_2);
    return images;
  }
};

module.exports = Product;

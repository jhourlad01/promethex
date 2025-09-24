const User = {
  async reviews(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT * FROM reviews WHERE user_id = ? ORDER BY created_at DESC',
      [parent.id]
    );
    return rows;
  }
};

module.exports = User;

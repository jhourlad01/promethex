const { ApolloServer } = require('apollo-server-express');
const express = require('express');
const cors = require('cors');
require('dotenv').config();

const typeDefs = require('./schema/typeDefs');
const resolvers = require('./resolvers');
const db = require('./config/database');

async function startServer() {
  const app = express();
  
  // Enable CORS
  app.use(cors());
  
  // Create Apollo Server
  const server = new ApolloServer({
    typeDefs,
    resolvers,
    context: ({ req }) => ({
      db,
      req
    }),
    introspection: true,
    playground: true
  });
  
  await server.start();
  server.applyMiddleware({ app, path: '/' });
  
  const PORT = process.env.PORT || 4000;
  
  app.listen(PORT, () => {
    console.log(`GraphQL API Server running at http://localhost:${PORT}`);
    console.log(`GraphQL Playground available at http://localhost:${PORT}`);
  });
}

startServer().catch(error => {
  console.error('Error starting server:', error);
});

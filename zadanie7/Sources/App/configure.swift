import NIOSSL
import Fluent
import FluentPostgresDriver
import Leaf
import Vapor

// configures your application
public func configure(_ app: Application) async throws {
    // Uncomment to serve files from /Public folder
    // app.middleware.use(FileMiddleware(publicDirectory: app.directory.publicDirectory))

    // Configure PostgreSQL database
    app.databases.use(.postgres(
        hostname: Environment.get("DATABASE_HOST") ?? "localhost",
        port: Environment.get("DATABASE_PORT").flatMap(Int.init(_:)) ?? PostgresConfiguration.ianaPortNumber,
        username: Environment.get("DATABASE_USERNAME") ?? "vapor_username",
        password: Environment.get("DATABASE_PASSWORD") ?? "vapor_password",
        database: Environment.get("DATABASE_NAME") ?? "vapor_database"
    ), as: .psql)

    // Add migrations
    app.migrations.add(CreateProduct())

    // Use Leaf for views
    app.views.use(.leaf)
    app.leaf.cache.isEnabled = app.environment.isRelease // opcjonalnie, dla włączenia cache w produkcji
    app.directory = DirectoryConfiguration.detect()

    // Run migrations
    try await app.autoMigrate()

    // Register routes
    try routes(app)
}

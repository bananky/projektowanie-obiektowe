import Fluent
import Vapor

func routes(_ app: Application) throws {
    // Renderowanie widoku głównego
    app.get { req async throws in
        try await req.view.render("index", ["title": "Hello Vapor!"])
    }

    // Endpoint "hello"
    app.get("hello") { req async -> String in
        "Hello, world!"
    }

    // Rejestracja kontrolera TodoController
    try app.register(collection: TodoController())

    // Rejestracja kontrolera ProductsController
    let productsController = ProductsController()
    try app.register(collection: productsController)
}

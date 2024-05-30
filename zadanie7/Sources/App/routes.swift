import Vapor

func routes(_ app: Application) throws {
    let productsController = ProductsController()

    app.get("products", use: productsController.index)
    app.get("products", ":productID", use: productsController.show)
    app.post("products", use: productsController.create)
    app.put("products", ":productID", use: productsController.update)
    app.get("products", ":productID", "delete", use: productsController.deleteHandler)
    app.post("products", ":productID", "delete", use: productsController.delete)
}

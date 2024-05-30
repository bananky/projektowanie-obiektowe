import Vapor
import Fluent

final class ProductsController {
    
    // Metoda do wyświetlania listy wszystkich produktów
    func index(req: Request) throws -> EventLoopFuture<View> {
        return Product.query(on: req.db).all().flatMap { products in
            let context = ["products": products]
            return req.view.render("/products/index", context)
        }
    }
    
    // Metoda do wyświetlania pojedynczego produktu
    func show(req: Request) throws -> EventLoopFuture<View> {
        guard let productID = req.parameters.get("productID", as: UUID.self) else {
            throw Abort(.badRequest)
        }
        return Product.find(productID, on: req.db).unwrap(or: Abort(.notFound)).flatMap { product in
            let context = ["product": product]
            return req.view.render("products/show", context)
        }
    }
    
    // Metoda do tworzenia nowego produktu
    func create(req: Request) throws -> EventLoopFuture<Response> {
        let product = try req.content.decode(Product.self)
        return product.save(on: req.db).map {
            return req.redirect(to: "products/create")
        }
    }
    
    // Metoda do aktualizowania istniejącego produktu
    func update(req: Request) throws -> EventLoopFuture<Response> {
        guard let productID = req.parameters.get("productID", as: UUID.self) else {
            throw Abort(.badRequest)
        }
        let updatedProduct = try req.content.decode(Product.self)
        return Product.find(productID, on: req.db).unwrap(or: Abort(.notFound)).flatMap { product in
            product.name = updatedProduct.name
            product.description = updatedProduct.description
            return product.save(on: req.db).map {
                return req.redirect(to: "products")
            }
        }
    }
    
    // Metoda do usuwania produktu
    func delete(req: Request) throws -> EventLoopFuture<Response> {
        guard let productID = req.parameters.get("productID", as: UUID.self) else {
            throw Abort(.badRequest)
        }
        return Product.find(productID, on: req.db).unwrap(or: Abort(.notFound)).flatMap { product in
            return product.delete(on: req.db).map {
                return req.redirect(to: "products")
            }
        }
    }
    
    // Metoda obsługująca widok formularza usuwania produktu
    func deleteHandler(req: Request) throws -> EventLoopFuture<View> {
        guard let productID = req.parameters.get("productID", as: UUID.self) else {
            throw Abort(.badRequest)
        }
        return Product.find(productID, on: req.db).unwrap(or: Abort(.notFound)).flatMap { product in
            let context = ["product": product]
            return req.view.render("delete", context)
        }
    }
    
}

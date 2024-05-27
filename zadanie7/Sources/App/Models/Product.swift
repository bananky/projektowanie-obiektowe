import Fluent
import Vapor

final class Product: Model, Content {
    static let schema = "products"

    @ID(key: .id)
    var id: UUID?

    @Field(key: "name")
    var name: String

    @Field(key: "description")
    var description: String?

    @Field(key: "price")
    var price: Double

    @Field(key: "stock")
    var stock: Int

    init() { }

    init(id: UUID? = nil, name: String, description: String? = nil, price: Double, stock: Int) {
        self.id = id
        self.name = name
        self.description = description
        self.price = price
        self.stock = stock
    }
}

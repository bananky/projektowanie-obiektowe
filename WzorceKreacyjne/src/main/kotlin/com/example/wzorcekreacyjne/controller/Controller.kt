package com.example.wzorcekreacyjne.controller
import com.example.wzorcekreacyjne.model.Produkt
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RequestMapping
import org.springframework.web.bind.annotation.RestController

@RestController
@RequestMapping("/api")
class Controller {

    private val produkty: List<Produkt> = listOf(
        Produkt(1, "taśma"),
        Produkt(2,"klej")
    )

    @GetMapping("/produkty")
    fun getProducts(): List<Produkt> {
        return produkty
    }

}
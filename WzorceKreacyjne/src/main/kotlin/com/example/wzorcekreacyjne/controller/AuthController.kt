package com.example.wzorcekreacyjne.controller

import com.example.wzorcekreacyjne.service.AuthService
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController

@RestController
class AuthController(private val authService: AuthService) {

    data class AuthRequest(
        val username: String,
        val password: String
    )

    @PostMapping("/login")
    fun login(@RequestBody request: AuthRequest): Any {
        val username = request.username
        val password = request.password

        return if (authService.authenticate(username, password)) {
            "Autoryzacja udana dla użytkownika: $username"
            Controller().getProducts()
        } else {
            "Błąd autoryzacji"
        }
    }
}

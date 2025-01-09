<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const password = ref('');

const handleLogin = async () => {
  if (email.value && password.value) {
    try {
      // Obtém o token CSRF
      await axios.get('/sanctum/csrf-cookie',{ withCredentials: true });
     
      const response = await axios.post('/login', {
        email: email.value,
        password: password.value,
      }, {
        headers: {
            'Accept': 'application/json', // Importante para receber JSON do Laravel
        },
        withCredentials: true, // Garante que os cookies sejam enviados
        });

      if (response.status === 200) {
        alert('Login realizado com sucesso!');
      }
    } catch (error) {
      console.error('Erro ao realizar login:', error.response?.data || error.message);
      alert('Erro ao realizar login. Verifique suas credenciais.');
    }
  } else {
    alert('Por favor, preencha todos os campos.');
  }
};
</script>

<template>
  <div class="login-container">
    <div class="login-box">
      <h1 class="main-title">Trídia Hospedagens</h1>
      
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" placeholder="Digite seu email" required />
        </div>
        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" v-model="password" placeholder="Digite sua senha" required />
        </div>
        <button type="submit" class="login-button">Entrar</button>
      </form>
      <p class="register-link">Não tem uma conta? <a href="#">Cadastre-se</a></p>
    </div>
  </div>
</template>



<style scoped>
body {
  margin: 0;
  border: none;
}
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('/public/images/hotel.jpg') no-repeat;
  background-size: cover;
  font-family: Arial, sans-serif;
  margin: 0;
  border: none;
}

.login-box {
  background: #fff;
  padding: 20px 40px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 400px;
  width: 100%;
}

.main-title {
  font-family: 'Georgia', serif;
  font-size: 24px;
  color: #333;
  margin-bottom: 40px;
}

h2 {
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 15px;
  text-align: left;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #555;
  font-weight: bold;
}

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 14px;
  box-sizing: border-box;
}

.login-button {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  cursor: pointer;
}

.login-button:hover {
  background-color: #45a049;
}

.register-link {
  margin-top: 15px;
  font-size: 14px;
  color: #555;
}

.register-link a {
  color: #4CAF50;
  text-decoration: none;
}

.register-link a:hover {
  text-decoration: underline;
}
</style>

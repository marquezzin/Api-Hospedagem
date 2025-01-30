<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/userStore';

const email = ref('');
const password = ref('');
const router   = useRouter();
const userStore = useUserStore(); 
import { toast } from 'vue3-toastify';

const handleLogin = async () => {
  if (email.value && password.value) {
    try {
      // Chama a ação de login da userStore
      await userStore.login({ email: email.value, password: password.value });
      router.push({ path: '/dashboard' });
      // Exibe notificação de sucesso
      setTimeout(() => {
        toast.success("Login realizado com sucesso!", {
        autoClose: 3000,
        position: "top-left",
        theme: "colored",
      });
      }, 250);

    } catch (error) {
      // Exibe erro em caso de falha no login
      toast.error("Erro ao realizar login. Verifique suas credenciais.", {
        autoClose: 3000,
        position: "top-left",
        theme: "colored",
      });
    }
  } else {
    // Exibe erro caso os campos não estejam preenchidos
    toast.warning("Por favor, preencha todos os campos.", {
      autoClose: 3000,
      position: "top-left",
      theme: "colored",
    });
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

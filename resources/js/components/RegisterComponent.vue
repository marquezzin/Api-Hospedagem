<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/userStore';
import { toast } from 'vue3-toastify';

const router = useRouter();
const userStore = useUserStore();

// Campos do formulário
const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const birthdate = ref('');
const is_foreigner = ref(0);
const cpf = ref('');
const rg = ref('');
const passport = ref('');

// Armazena os erros do backend
const backendErrors = ref({});

const handleRegister = async () => {
  backendErrors.value = {}; // Limpa erros anteriores

  const userData = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    birthdate: birthdate.value,
    is_foreigner: is_foreigner.value,
    cpf: is_foreigner.value == 0 ? cpf.value : null,
    rg: is_foreigner.value == 0 ? rg.value : null,
    passport: is_foreigner.value == 1 ? passport.value : null,
  };

  try {
    await userStore.registerUser(userData);
    router.push('/');

    setTimeout(() => {
        toast.success("Cadastro realizado com sucesso!", {
        autoClose: 3000,
        position: "top-left",
        theme: "colored",
      });
      }, 250);
  } catch (error) {
    if (error.response && error.response.data.errors) {
      backendErrors.value = error.response.data.errors; // Armazena os erros recebidos

      Object.values(error.response.data.errors).forEach(errorMessages => {
        errorMessages.forEach(msg => {
          toast.error(msg, {
            autoClose: 5000,
            position: "top-left",
            theme: "colored",
          });
        });
      });
    } else {
      toast.error("Erro ao realizar cadastro. Tente novamente.", {
        autoClose: 3000,
        position: "top-left",
        theme: "colored",
      });
    }
  }
};
</script>

<template>
  <div class="register-container">
    <div class="register-box">
      <h1 class="main-title">Cadastro</h1>

      <form @submit.prevent="handleRegister">
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" id="name" v-model="name" placeholder="Digite seu nome" required />
          <span v-if="backendErrors.name" class="error-message">{{ backendErrors.name[0] }}</span>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" placeholder="Digite seu email" required />
          <span v-if="backendErrors.email" class="error-message">{{ backendErrors.email[0] }}</span>
        </div>

        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" v-model="password" placeholder="Crie sua senha" required />
          <span v-if="backendErrors.password" class="error-message">{{ backendErrors.password[0] }}</span>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirme a Senha</label>
          <input type="password" id="password_confirmation" v-model="password_confirmation" placeholder="Confirme sua senha" required />
        </div>

        <div class="form-group">
          <label for="birthdate">Data de Nascimento</label>
          <input type="date" id="birthdate" v-model="birthdate" required />
          <span v-if="backendErrors.birthdate" class="error-message">{{ backendErrors.birthdate[0] }}</span>
        </div>

        <div class="form-group">
          <label for="is_foreigner">É estrangeiro?</label>
          <select id="is_foreigner" v-model="is_foreigner">
            <option :value="0">Não</option>
            <option :value="1">Sim</option>
          </select>
        </div>

        <div v-if="is_foreigner == 0">
          <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" v-model="cpf" placeholder="Digite seu CPF" required />
            <span v-if="backendErrors.cpf" class="error-message">{{ backendErrors.cpf[0] }}</span>
          </div>

          <div class="form-group">
            <label for="rg">RG</label>
            <input type="text" id="rg" v-model="rg" placeholder="Digite seu RG" required />
            <span v-if="backendErrors.rg" class="error-message">{{ backendErrors.rg[0] }}</span>
          </div>
        </div>

        <div v-if="is_foreigner == 1">
          <div class="form-group">
            <label for="passport">Passaporte</label>
            <input type="text" id="passport" v-model="passport" placeholder="Digite seu passaporte" required />
            <span v-if="backendErrors.passport" class="error-message">{{ backendErrors.passport[0] }}</span>
          </div>
        </div>

        <button type="submit" class="register-button">Cadastrar</button>
      </form>

      <p class="login-link">
        Já tem uma conta? <a href="#" @click.prevent="router.push('/')">Faça login</a>
      </p>
    </div>
  </div>
</template>

<style scoped>
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('/public/images/hotel.jpg') no-repeat;
  background-size: cover;
  font-family: Arial, sans-serif;
}

.register-box {
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

input, select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 14px;
  box-sizing: border-box;
}

.register-button {
  width: 100%;
  padding: 10px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  cursor: pointer;
}
.login-link {
  margin-top: 15px;
  font-size: 14px;
  color: #555;
}

.login-link a {
  color: #007BFF;
  text-decoration: none;
}

.register-button:hover {
  background-color: #0056b3;
}

small.invalid {
  color: red;
  font-size: 12px;
}

.error-message {
  color: red;
  font-size: 12px;
  display: block;
  margin-top: 5px;
}
</style>

<script setup>
import { computed, onMounted } from 'vue';
import { useUserStore } from '@/stores/userStore';

const userStore = useUserStore();

// Computed para acessar o estado do usuário
const user = computed(() => userStore.user);

// Busca o usuário autenticado ao recarregar a pagina
onMounted(async () => {
  if (!userStore.user) {
    await userStore.fetchUser(); // Busca o usuário se ainda não estiver carregado
  }
});

console.log(user);
</script>

<template>
  <div class="dashboard-container">
    <div class="dashboard-card">
      <h1 class="dashboard-title">Bem-vindo ao Dashboard, {{ user?.guest?.name || 'Usuário' }}!</h1>
      <p class="dashboard-subtitle">Aqui estão suas informações cadastradas:</p>

      <div class="dashboard-grid">
        <div class="dashboard-item">
          <span class="label">Email:</span>
          <span class="value">{{ user?.email }}</span>
        </div>
        <div class="dashboard-item">
          <span class="label">CPF:</span>
          <span class="value">{{ user?.guest?.cpf }}</span>
        </div>
        <div class="dashboard-item">
          <span class="label">Data de Nascimento:</span>
          <span class="value">{{ user?.guest?.birthdate }}</span>
        </div>
        <div class="dashboard-item">
          <span class="label">Conta Criada em:</span>
          <span class="value">{{ new Date(user?.created_at).toLocaleDateString() }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* Container principal */
.dashboard-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('/public/images/hotel.jpg') no-repeat;
  background-size: cover;
  
  margin: 0;
  border: none;
}

/* Cartão central */
.dashboard-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  max-width: 600px;
  width: 100%;
}

/* Título e subtítulo */
.dashboard-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #333;
}

.dashboard-subtitle {
  font-size: 16px;
  margin-bottom: 20px;
  color: #666;
}

/* Grid de informações */
.dashboard-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
}

/* Estilo de cada item */
.dashboard-item {
  background: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 10px;
}

.label {
  display: block;
  font-size: 14px;
  color: #888;
  margin-bottom: 5px;
}

.value {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}
</style>

<!-- computed: Serve para reagir automaticamente às mudanças no estado userStore.user e atualizar o template. -->
<!-- onMounted: Garante que os dados do estado userStore.user sejam carregados na inicialização do componente, caso ainda não estejam disponíveis. -->

<!-- Ao recarregar o navegador:
O onMounted busca os dados do usuário.
O computed garante que o template seja atualizado automaticamente quando os dados do usuário forem carregados. -->
<script setup>
import { computed, onMounted } from 'vue';
import { useUserStore } from '@/stores/userStore';
import { useRouter } from 'vue-router';
import { usePhoneStore } from '@/stores/phoneStore';
import { useAddressStore } from '@/stores/addressStore';

const router   = useRouter();
const userStore = useUserStore();
const phoneStore = usePhoneStore();
const addressStore = useAddressStore();

// Computed para acessar o estado do usuário
const user = computed(() => userStore.user);
const phones = computed(() => phoneStore.phones);
const addresses = computed(() => addressStore.addresses);

// Busca o usuário autenticado ao recarregar a pagina
onMounted(async () => {
  if (!userStore.user) {
    await userStore.fetchUser(); // Sem o await: o código continuaria a execução sem esperar que os dados do usuário fossem carregados.
  }
  // Obtém o guestId do usuário logado
  const guestId = user.value?.guest?.id;
  if (guestId) {
    await phoneStore.fetchPhone(guestId); // Busca os telefones 
    await addressStore.fetchAddress(guestId); // Busca os endereços
  }
});

// Função para redirecionamento
const goToReservation = () => {
  router.push('/reservation'); // Redireciona para a página de reserva
};

console.log(user);
</script>

<template>
  <div class="dashboard-container">
    <div class="dashboard-card">
      <h1 class="dashboard-title">Bem-vindo à Trídia, {{ user?.guest?.name || 'Usuário' }}!</h1>
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
          <span class="value">{{ new Date(user?.guest?.birthdate).toLocaleDateString() }}</span>
        </div>
        <div class="dashboard-item">
          <span class="label">Conta Criada em:</span>
          <span class="value">{{ new Date(user?.created_at).toLocaleDateString() }}</span>
        </div>
       <!-- Telefones -->
       <div class="dashboard-item full-width">
          <span class="label">Telefones:</span>
          <ul v-if="phones.length">
            <li v-for="phone in phones" :key="phone.id">
              {{ phone.type }}: {{ phone.number }}
            </li>
          </ul>
          <p v-else>Nenhum telefone cadastrado.</p>
        </div>
      </div>
      <!-- Endereços -->
      <div class="dashboard-item full-width addresses">
          <span class="label">Endereços:</span>
          <ul v-if="addresses.length">
            <li v-for="address in addresses" :key="address.id">
              {{ address.street }}, Nº {{ address.number }} - {{ address.district }} <br>
              {{ address.city }} - {{ address.state }} - CEP: {{ address.zipcode }}
              <span v-if="address.complement"> ({{ address.complement }})</span>
            </li>
          </ul>
          <p v-else>Nenhum endereço cadastrado.</p>
        </div>
       <!-- Botão centralizado -->
       <div class="button-container">
        <button class="reservation-button" @click="goToReservation">
          <span>Minhas Reservas</span>
        </button>
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
  background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('/public/images/hotel.jpg') no-repeat;
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

.dashboard-item.full-width {
  grid-column: span 2;
  height: 100px;
  overflow-y: auto;
}

.dashboard-item.full-width.addresses {
  margin-top: 15px;
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

.button-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  width: 100%;
}

/* Estilização do botão */
.reservation-button {
  background-color: #5bb8bb;
  color: white;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  font-weight: bold;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
  width: auto; /* Garante que o botão não ocupe toda a largura */
  min-width: 200px; /* Evita que o botão fique muito pequeno */
  text-align: center;
}

.reservation-button:hover {
  background-color: #2e546c;
}
</style>

<!-- computed: Serve para reagir automaticamente às mudanças no estado userStore.user e atualizar o template. -->
<!-- onMounted: Garante que os dados do estado userStore.user sejam carregados na inicialização do componente, caso ainda não estejam disponíveis. -->

<!-- Ao recarregar o navegador:
O onMounted busca os dados do usuário.
O computed garante que o template seja atualizado automaticamente quando os dados do usuário forem carregados. -->
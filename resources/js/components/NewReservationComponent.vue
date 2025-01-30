<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/userStore';
import { useReservationStore } from '@/stores/reservationStore';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const reservationStore = useReservationStore();
const userStore = useUserStore();
const router = useRouter();

// Computed para acessar o estado do usuário
const user = computed(() => userStore.user);

// Pegando o guestId manualmente do usuário logado
const guestId = computed(() => user.value?.guest?.id);

// Estados para armazenar as datas selecionadas
const checkinDate = ref('');
const checkoutDate = ref('');
const errorMessage = ref('');

// Busca o usuário ao carregar o componente
onMounted(async () => {
  if (!userStore.user) {
    await userStore.fetchUser();
  }
});

// Função para salvar a reserva
// Função para salvar a reserva
const saveReservation = async () => {
  if (!checkinDate.value || !checkoutDate.value) {
    errorMessage.value = "Por favor, preencha ambas as datas.";
    return;
  }

  if (new Date(checkinDate.value) >= new Date(checkoutDate.value)) {
    errorMessage.value = "A data de check-out deve ser posterior à data de check-in.";
    return;
  }

  if (!guestId.value) {
    errorMessage.value = "Hóspede não encontrado.";
    return;
  }

  try {
    await reservationStore.createReservation({
      checkin_date: checkinDate.value,
      checkout_date: checkoutDate.value
    }, guestId.value); // Passando o guestId manualmente

    router.push('/reservation');
    // Exibe notificação de sucesso
    setTimeout(() => {
        toast.success("Reserva criada com sucesso!", {
        autoClose: 3000,
        position: "top-left",
        theme: "colored",
      });
      }, 250);
  } catch (error) {
    toast.error('Erro ao criar reserva. Tente novamente.');
  }
};
</script>

<template>
    <div class="reservation-container">
      <div class="reservation-card">
        <h1 class="reservation-title">Criar Reserva</h1>
  
        <!-- Campos de entrada para as datas -->
        <div class="form-group">
          <label for="checkin">Data de Check-in</label>
          <input type="date" id="checkin" v-model="checkinDate" required />
        </div>
  
        <div class="form-group">
          <label for="checkout">Data de Check-out</label>
          <input type="date" id="checkout" v-model="checkoutDate" required />
        </div>
  
        <!-- Mensagem de erro -->
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  
        <!-- Botão de salvar reserva -->
        <button @click="saveReservation" class="save-btn">
          Salvar Reserva
        </button>
      </div>
    </div>
  </template>
  
  <style scoped>
  /* Container centralizado */
  .reservation-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('/public/images/hotel.jpg') no-repeat;
    background-size: cover;
    padding: 20px;
  }
  
  /* Card de reserva */
  .reservation-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 500px;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
  }
  
  /* Título */
  .reservation-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
  }
  
  /* Grupo de formulário */
  .form-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 15px;
    width: 100%;
  }
  
  .form-group label {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
  }
  
  .form-group input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box; /* Garante que padding e border não aumentem o tamanho */
  }
  
  /* Mensagem de erro */
  .error-message {
    color: #ff4d4d;
    font-size: 14px;
    margin-bottom: 10px;
  }
  
  /* Botão de salvar */
  .save-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
    width: 100%;
    box-sizing: border-box;
  }
  
  .save-btn:hover {
    background: #0056b3;
  }
  </style>

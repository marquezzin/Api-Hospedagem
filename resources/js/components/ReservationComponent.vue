<script setup>
import { computed, onMounted } from 'vue';
import { useUserStore } from '@/stores/userStore';
import { useReservationStore } from '@/stores/reservationStore';

const reservationStore = useReservationStore();
const userStore = useUserStore();
const reservation = computed(() => reservationStore.reservation);


// Computed para acessar o estado do usuário
const user = computed(() => userStore.user);
const reservations = computed(() => reservationStore.reservations);

// Busca o usuário e sua reserva ao carregar o componente
onMounted(async () => {
  if (!userStore.user) {
    await userStore.fetchUser(); // Garante que o usuário seja carregado
  }

  const guestId = user.value?.guest?.id;
  console.log(guestId)
  if (guestId) {
    await reservationStore.fetchReservation(guestId); // Busca a reserva com base no ID do guest
  }
});
// Função para formatar datas simples
const formatDate = (date) => {
  if (!date) return "N/A";
  return new Date(date).toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric"
  });
};

// Função para formatar data e hora
const formatDateTime = (dateTime) => {
  if (!dateTime) return "N/A";
  return new Date(dateTime).toLocaleString("pt-BR", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit"
  });
};

console.log(user.value);
console.log(reservations.value);

</script>

<template>
    <div class="reservations-container">
    <div class="reservations-card">
      <h1 class="reservations-title">Minhas Reservas</h1>

      <!-- Se não houver reservas -->
      <p v-if="reservations.length === 0" class="no-reservations">
        Você ainda não possui reservas.
      </p>

      <!-- Lista de reservas -->
      <div v-else class="reservations-list">
        <div v-for="reservation in reservations" :key="reservation.id" class="reservation-item">
          <h2 class="reservation-hotel">Reserva #{{ reservation.id }}</h2>
          
          <!-- Datas principais -->
          <p class="reservation-dates">
            Data para check-in: <strong>{{ formatDate(reservation.checkin_date) }}</strong> | 
            Data para check-out: <strong>{{ formatDate(reservation.checkout_date) }}</strong>
          </p>

          <!-- Informações do Pivot (se existirem) -->
          <p v-if="reservation.pivot" class="reservation-pivot">
            <span>Check-in realizado : <strong>{{ formatDate(reservation.pivot.checkin_at) }}</strong></span> |
            <span>Check-out realizado: <strong>{{ formatDate(reservation.pivot.checkout_at) }}</strong></span> |
            <span>Tipo: <strong>{{ reservation.pivot.type }}</strong></span>
          </p>

          <!-- Status da reserva -->
          <p class="reservation-status">
            Status: 
            <strong v-if="reservation.deleted_at">Cancelada</strong>
            <strong v-else>Ativa</strong>
          </p>

          <!-- Data de atualização -->
          <p class="reservation-updated">
            Última atualização: <strong>{{ formatDateTime(reservation.updated_at) }}</strong>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* Container principal */
.reservations-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('/public/images/hotel.jpg') no-repeat;
  background-size: cover;
}

/* Cartão central */
.reservations-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  max-width: 600px;
  width: 100%;
  text-align: center;
}

/* Título */
.reservations-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
}

/* Lista de reservas */
.reservations-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

/* Item de reserva */
.reservation-item {
  background: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 15px;
  text-align: left;
}

/* Nome do hotel */
.reservation-hotel {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 5px;
  color: #007bff;
}

/* Datas */
.reservation-dates {
  font-size: 14px;
  color: #333;
  margin-bottom: 5px;
}

/* Pivot */
.reservation-pivot {
  font-size: 14px;
  font-style: italic;
  color: #555;
  margin-bottom: 5px;
}

/* Status */
.reservation-status {
  font-size: 14px;
  font-weight: bold;
  color: #555;
}

/* Data de atualização */
.reservation-updated {
  font-size: 12px;
  color: #888;
}
</style>

<!-- computed: Serve para reagir automaticamente às mudanças no estado userStore.user e atualizar o template. -->
<!-- onMounted: Garante que os dados do estado userStore.user sejam carregados na inicialização do componente, caso ainda não estejam disponíveis. -->

<!-- Ao recarregar o navegador:
O onMounted busca os dados do usuário.
O computed garante que o template seja atualizado automaticamente quando os dados do usuário forem carregados. -->
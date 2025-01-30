<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/userStore';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


const userStore = useUserStore();
const router = useRouter();
const user = computed(() => userStore.user);
const showDropdown = ref(false);

// Função para fazer logout
const handleLogout = async () => {
  try {
    await userStore.logout();
    
    showDropdown.value = false;
    router.push('/');
    setTimeout(() => {
      toast.success('Logout realizado com sucesso!', { autoClose: 1000 });
    }, 1000);
    
    
  } catch (error) {
    toast.error('Erro ao deslogar. Tente novamente.');
  }
};

// Função para ir para o Dashboard
const goToDashboard = () => {
  showDropdown.value = false; // Fechar o dropdown após o clique
  setTimeout(() => {
      router.push('/dashboard');
    }, 1000);
};

// Alternar dropdown
const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};

</script>

<template>
  <div class="container">
    <!-- Botão fixo do usuário -->
    <div v-if="user" class="user-button">
      <button @click="toggleDropdown" class="user-icon">
        <FontAwesomeIcon :icon="['fas', 'bars']" />
      </button>

       <!-- Dropdown -->
      <transition name="dropdown-fade">
        <div v-if="showDropdown" class="dropdown-menu">
          <button @click="goToDashboard" class="profile-option">
            <FontAwesomeIcon :icon="['fas', 'user']" /> Meus dados
          </button>
          <button @click="handleLogout" class="logout-option">
            <FontAwesomeIcon :icon="['fas', 'sign-out-alt']" /> Sair
          </button>
        </div>
      </transition>
    </div>

    <!-- Ponto de injeção do Vue Router -->
    <router-view />
  </div>
</template>

<style scoped>
.container {
  position: relative;
}

/* Botão do usuário */
.user-button {
  position: fixed;
  top: 15px;
  right: 15px;
  z-index: 1000;
}

/* Ícone do usuário */
.user-icon {
  background-color: #ffffff;
  border: 2px solid #4da3ff;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  cursor: pointer;
  color: #4da3ff;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.user-icon:hover {
  background-color: #4da3ff;
  color: white;
}

/* Dropdown */
.dropdown-menu {
  position: absolute;
  top: 55px;
  right: 0;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  width: 160px;
  padding: 12px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

/* Opção de perfil ("Meus dados") */
.profile-option {
  background: none;
  border: none;
  color: #333; /* Cor neutra */
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px;
}

.profile-option:hover {
  background-color: #e0e0e0; /* Fundo cinza ao passar o mouse */
  border-radius: 5px;
}

/* Botão de logout */
.logout-option {
  background: none;
  border: none;
  color: #ff4d74; /* Vermelho */
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px;
}

.logout-option:hover {
  background-color: #f35656;
  color: white;
  border-radius: 5px;
}

/* Transição do dropdown */
.dropdown-fade-enter-active, .dropdown-fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.dropdown-fade-enter-from, .dropdown-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>

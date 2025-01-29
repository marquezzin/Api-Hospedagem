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
    toast.success('Logout realizado com sucesso!', { autoClose: 2000 });
    showDropdown.value = false;
    router.push('/');
  } catch (error) {
    toast.error('Erro ao deslogar. Tente novamente.');
  }
};

// Alternar dropdown
const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};
console.log(user)
</script>

<template>
  <div class="container">
    <!-- Botão fixo do usuário -->
    <div v-if="user" class="user-button">
      <button @click="toggleDropdown" class="user-icon">
        <i class="fa-brands fa-vuejs"></i>
      </button>

      <!-- Dropdown -->
      <div v-if="showDropdown" class="dropdown-menu">
        <button @click="handleLogout" class="logout-option">
          asdasds
        </button>
      </div>
    </div>

    <!-- Ponto de injeção do Vue Router -->
    <router-view />
  </div>
</template>

<style scoped>
.container {
  position: relative;
}

.user-button {
  position: fixed;
  top: 10px;
  right: 10px;
  z-index: 1000;
}

.user-icon {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #333;
}

.user-icon:hover {
  color: #4CAF50;
}

.dropdown-menu {
  position: absolute;
  top: 40px;
  right: 0;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  width: 120px;
  padding: 10px;
  display: flex;
  flex-direction: column;
}

.logout-option {
  background: none;
  border: none;
  color: #e74c3c;
  font-size: 14px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}

.logout-option:hover {
  color: #c0392b;
}
</style>

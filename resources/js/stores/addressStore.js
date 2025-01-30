import { defineStore } from 'pinia';
import axios from 'axios';

export const useAddressStore = defineStore('address', {
  state: () => ({
    addresses: [], // Lista de endereços do hóspede
  }),

  actions: {
    async fetchAddress(guestId) {
      try {
        if (!guestId) throw new Error('ID do hóspede inválido');

        const response = await axios.get(`/api/guests/${guestId}/addresses`, { withCredentials: true });
        this.addresses = response.data; // Atualiza a lista de endereços
      } catch (error) {
        console.error('Erro ao buscar os endereços:', error.response?.data || error.message);
        this.addresses = [];
      }
    }
  }
});

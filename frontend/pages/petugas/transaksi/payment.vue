<script setup lang="ts">

const route = useRoute()

const id = route.query.id

</script>

<template>

  <div class="container">

    <div class="card">

      <h1>Pembayaran Parkir</h1>

      <p class="subtitle">
        Halaman pembayaran transaksi parkir
      </p>

      <div class="info">

        <div class="row">
          <span>ID Transaksi</span>
          <strong>{{ id || '-' }}</strong>
        </div>

        <div class="row">
          <span>Status</span>
          <span class="status">
            BELUM DIBAYAR
          </span>
        </div>

      </div>

      <button
        class="btn"
        @click="navigateTo('/petugas/member/select')"
      >
        Kembali ke Member
      </button>

    </div>

  </div>

</template>

<style scoped>

.container {
  min-height: 100vh;
  padding: 40px;
  background: #f5f6fa;
  font-family: Arial, sans-serif;
}

.card {
  max-width: 600px;
  margin: auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

h1 {
  margin: 0;
  font-size: 24px;
}

.subtitle {
  color: #777;
  margin-top: 8px;
}

.info {
  margin-top: 25px;
  border: 1px solid #ddd;
  border-radius: 6px;
  overflow: hidden;
}

.row {
  display: flex;
  justify-content: space-between;
  padding: 15px;
  border-bottom: 1px solid #ddd;
}

.row:last-child {
  border-bottom: none;
}

.status {
  background: #fee2e2;
  color: #dc2626;
  padding: 5px 10px;
  border-radius: 15px;
  font-size: 12px;
}

.btn {
  margin-top: 25px;
  padding: 10px 18px;
  border: none;
  border-radius: 5px;
  background: #315ee8;
  color: white;
  cursor: pointer;
}

.btn:hover {
  background: #244bc0;
}

</style>
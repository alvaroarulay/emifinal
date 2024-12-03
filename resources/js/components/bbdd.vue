<template>
    <main class="app-content">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card shadow-lg border-0 rounded-lg mt-12">
                    <div class="card-header">
                        <h3><b>Base de Datos:</b> &nbsp; &nbsp;Vsiaf</h3>
                    </div>
                    <div class="card-body">
                        <div class="logo">
                            <img src="/img/bbdd.png" alt="" style="width: 200px; ">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button @click="viafzip()" class="btn btn-success btn-lg">Generar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
export default {
  data() {
    return {
    }
  },
  methods: {
    viafzip(){
      window.open('http://192.168.28.219/download-zipvsiaf');
    }
  }
}
</script>
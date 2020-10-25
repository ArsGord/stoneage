<template>
<div>
  <div>
    <div class="navbar bg-light my-lg-0">
        <div>Stone Age</div>
        <div>
            <button @click="step = 1" type="button" class="btn btn-success my-2 my-sm-0">Вход</button>
            <button @click="step = 2" type="button" class="btn btn-primary ml-3 my-2 my-sm-0">Регистрация</button>
        </div>
    </div>
  </div>
  <div class="container mt-5">
      <div class="col-sm-4 mx-auto">
            <div>
              <login v-show="step == 1" />
            </div>
            <div>
              <reg v-show="step == 2" />
            </div>
        </div>
    </div>
</div>

  
</template>

<script>
import login from "./components/login.vue"
import reg from "./components/reg"

export default {
  components: {
    login,
    reg
  },
  data() {
    return {
      step: 1,
    }
  }
};
</script>
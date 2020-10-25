<template>
    <form @submit.prevent="userLogister" novalidate>
      <!-- Страница входа -->
        <div>
          <h2>Вход</h2>
          <div class="form-group">
            <label for="login">Логин</label>
            <input
              @blur="$v.formLog.login.$touch()"
              :class="status($v.formLog.login)"
              v-model.trim="formLog.login"
              type="text"
              class="form-control"
              id="login"
            />
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formLog.login.$required" class="invalid-feedback">
              {{reqText}}
            </div>
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formLog.login.$minLength" class="invalid-feedback">
              {{minLengthText4}}
            </div>
          </div>

          <!-- Пароль входа -->
          <div class="form-group">
            <label for="password">Пароль</label>
            <div class="passwordLog">
              <input
                @blur="$v.formLog.password.$touch()"
                :class="status($v.formLog.password)"
                v-model.trim="formLog.password"
                :type="type"
                class="form-control"
                id="password"
              />
              <a href="#" class="password-show" v-on:click="func"><img id="no-view-eye" src='../images/view.svg'></a>
            </div>
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formLog.password.$required" class="invalid-feedback">
              {{reqText}}
            </div>
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formLog.password.$minLength" class="invalid-feedback">
              {{minLengthText6}}
            </div>
          </div>
          <button @click="loginUser" :disabled="disabledLog" type="button" class="btn btn-success btn-block">Вход</button>
        </div>
    </form>
</template>

<script>
import { required, minLength} from 'vuelidate/lib/validators'
import { Server } from "../modules/Server"

export default {
  data() {
    return {
      reqText: 'Поле обязательно для заполнения',
      minLengthText6: 'Минимальная длина 6 символов!',
      minLengthText4: 'Минимальная длина 4 символов!',
      regMessage: false,
      type: "password",
      show: false,
      formLog:{
        login: "",
        password: "",
      },
      inputReg:{
        loginReg: "",
        nicknameReg: " ",
        passwordReg: "",
        passwordConfirm: "",
      },
      viewUrl: require('../images/view.svg'),
      noViewUrl: require('../images/no-view.svg'),
      Server: new Server()
    };
  },
  computed: {
    // функция отключает кнопку логина, если не пройдена валидация
    disabledLog() {
      return (
        this.$v.formLog.login.$invalid ||
        this.$v.formLog.password.$invalid
      )
    },
  },
  methods: {
    loginUser() {
      console.log(this.Server)
      console.log(this.formLog);
    },

    func() {
      this.show = !this.show
      if (this.show) {
        this.type = 'text'
        const eye = document.getElementById('no-view-eye');
        if (eye) {
          eye.setAttribute('src', this.noViewUrl)
          eye.setAttribute('id', 'view-eye')
        }
      } else {
        this.type = 'password'
        const eye = document.getElementById('view-eye');
        if (eye) {
          eye.setAttribute('src', this.viewUrl)
          eye.setAttribute('id', 'no-view-eye')
        }
      } 
      console.log(this.Server)
      //console.log(this.formLog);
    },
    status(validation) {
       return {
         'is-invalid': validation.$error,
         'error': validation.$error
       }
    },
  },
  //валидация введенных данных
  validations: {
    formLog: {
      login: {
        required,
        minLength: minLength(4),
      },
      password: {
        required,
        minLength: minLength(6),
      },
    },  
  },
};
</script>

<style scoped>
  .slide-fade-enter-active {
    transition: all 0.3s ease;
  }

  .slide-fade-enter{
    transform: translateX(10px);
    opacity: 0;
  }
</style>
<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-4 mx-auto">
        <form @submit.prevent="userRegister" novalidate>
          <!-- Страница входа -->
          <transition name="slide-fade" appear>
            <div  v-show="step === 1">
              <h2>Вход</h2>
              <!-- Сообщение об успешной регистрации -->
              <div v-if="regMessage" class="alert alert-success" role="alert">
                Вы успешно зарегистрировались!
              </div>
              <!-- Логин входа -->
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

                <div v-if="!$v.formLog.login.$required" class="invalid-feedback">
                  {{reqText}}
                </div>

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
                  <a href="#" class="password-show" v-on:click="func"><img id="no-view" src="../public/images/view.svg"></a>
                </div>
                <button type="button" class="btn btn-outline-info mt-2" @click="func">{{ show ? "Скрыть" : "показать" }}</button>
                <div v-if="!$v.formLog.password.$required" class="invalid-feedback">
                  {{reqText}}
                </div>

                <div v-if="!$v.formLog.password.$minLength" class="invalid-feedback">
                  {{minLengthText6}}
                </div>
              </div>
              <button @click="loginUser" :disabled="disabledLog" type="button" class="btn btn-success">Вход</button>
              <button @click="step++" type="button" class="btn btn-primary ml-3">Регистрация</button>
            </div>
          </transition>

          <!-- Страница регистрации -->
          <transition name="slide-fade" >
            <div v-show="step === 2">
              <h2>Регистрация</h2>
              <!-- Логин регистрации -->
              <div class="form-group">
                <label for="loginReg">Логин</label>
                <input
                  @blur="$v.formReg.loginReg.$touch()"
                  :class="status($v.formReg.loginReg)"
                  v-model.trim="formReg.loginReg"
                  type="text"
                  class="form-control"
                  id="loginReg"
                />

                <div v-if="!$v.formReg.loginReg.$required" class="invalid-feedback">
                  {{reqText}}
                </div>

                <div v-if="!$v.formReg.loginReg.$minLength" class="invalid-feedback">
                  {{minLengthText4}}
                </div>
              </div>

              <!-- Никнейм -->
              <div class="form-group">
                <label for="nicknameReg">Имя в игре</label>
                <input
                  @blur="$v.formReg.nicknameReg.$touch()"
                  :class="status($v.formReg.nicknameReg)"
                  v-model.trim="formReg.nicknameReg"
                  type="text"
                  class="form-control"
                  id="nicknameReg"
                />
                <div v-if="!$v.formReg.nicknameReg.$required" class="invalid-feedback">
                  {{reqText}}
                </div>
              </div>

              <!-- Пароль регистрации -->
              <div class="form-group">
                <label for="passwordReg">Пароль</label>
                  <div class="passwordLog">
                  <input
                    @blur="$v.formReg.passwordReg.$touch()"
                    :class="status($v.formReg.passwordReg)"
                    v-model.trim="formReg.passwordReg"
                    :type="type1"
                    class="form-control"
                    id="passwordReg"
                  />
                  <a href="#" class="password-show" v-on:click="func1"><img id="no-viewReg" src="../public/images/view.svg"></a>
                  </div>
                <button type="button" class="btn btn-outline-info mt-2" @click="func1">{{ show1 ? "Скрыть" : "показать" }}</button>
                <div v-if="!$v.formReg.passwordReg.$required" class="invalid-feedback">
                  {{reqText}}
                </div>

                <div v-if="!$v.formReg.passwordReg.$minLength" class="invalid-feedback">
                  {{minLengthText6}}
                </div>
              </div>

              <!-- Подтверждение пароля регистрации -->
              <div class="form-group">
                <label for="passwordConfirm">Подтверждение пароля</label>
                <div class="passwordLog">
                <input
                  @blur="$v.formReg.passwordConfirm.$touch()"
                  :class="status($v.formReg.passwordConfirm)"
                  v-model.trim="formReg.passwordConfirm"
                  :type="type2"
                  class="form-control"
                  id="passwordConfirm"
                />
                <a href="#" class="password-show" v-on:click="func2"><img id="no-viewRegConf" src="../public/images/view.svg"></a>
                </div>
                <button type="button" class="btn btn-outline-info mt-2" @click="func2">{{ show2 ? "Скрыть" : "показать" }}</button>
                <div class="invalid-feedback" v-if="!$v.formReg.passwordConfirm.$required">
                  {{reqText}}
                </div>

                <div v-if="!$v.formReg.passwordConfirm.$sameAs" class="invalid-feedback">
                  {{passwordConfirmText}}
                </div>
              </div>

              <button @click="step--" type="button" class="btn btn-light">Назад</button>
              <button :disabled="disabledReg" @click="registerUser" type="button" class="btn btn-primary ml-3">
                Зарегистрироваться
              </button>
            </div>
          </transition>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { required, minLength, sameAs } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      reqText: 'Поле обязательно для заполнения',
      minLengthText6: 'Минимальная длина 6 символов!',
      minLengthText4: 'Минимальная длина 4 символов!',
      passwordConfirmText: 'Пароли не совпадают',
      regMessage: false,
      type: "password",
      type1: "password",
      type2: "password",
      show: false,
      show1: false,
      show2: false,
      step: 1,
      formReg: {
        loginReg: "",
        nicknameReg: "",
        passwordReg: "",
        passwordConfirm: "",
      },
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
      viewUrl: require('../public/images/view.svg'),
      noViewUrl: require('../public/images/no-view.svg')
    };
  },
  computed: {
    disabledReg() {
      return (
        this.$v.formReg.nicknameReg.$invalid ||
        this.$v.formReg.loginReg.$invalid ||
        this.$v.formReg.passwordReg.$invalid ||
        this.$v.formReg.passwordConfirm.$invalid
      );
    },
    disabledLog() {
      return (
        this.$v.formLog.login.$invalid ||
        this.$v.formLog.password.$invalid
      )
    },
  },
  methods: {

    registerUser() {
      for (let input in this.formReg) {
            this.inputReg[input] = this.formReg[input]
      }
      
      console.group()
          console.log('Вы успешно зарегистрированны!')
          console.log('Ваше имя: ' + this.formReg.loginReg)
          console.log('Ваш никнейи: ' + this.formReg.nicknameReg)
          console.log('Ваш пароль: ' + this.formReg.passwordReg)
      console.groupEnd()

      console.log(this.inputReg)

      this.reset()
    },
    loginUser() {
      console.log(this.formLog);
    },
    reset() {
        // сбросить шаг и показать сообщение о регистрации
        this.step = 1;
        this.regMessage = true;
        // убрать сообщение о регистрации
        setTimeout(() => {
          this.regMessage = false
        }, 3000)
        // сбросить все поля
        for (let input in this.formReg) {
            this.formReg[input] = ''
        }
        for (let input in this.formLog) {
            this.formLog[input] = ''
        }
        // сбросить валидацию
        this.$v.$reset()
    },
    func() {
      this.show = !this.show
      if (this.show) {
        this.type = 'text'
        const eye = document.getElementById('no-view');
        if (eye) {
          eye.setAttribute('src', this.noViewUrl)
          eye.setAttribute('id', 'view')
        }
      } else {
        this.type = 'password'
        const eye = document.getElementById('view');
        if (eye) {
          eye.setAttribute('src', this.viewUrl)
          eye.setAttribute('id', 'no-view')
        }
      } 
    },
    func1() {
      this.show1 = !this.show1
      if (this.show1) {
        this.type1 = 'text'
        const eye = document.getElementById('no-viewReg');
        console.log(eye);
        if (eye) {
          eye.setAttribute('src', this.noViewUrl)
          eye.setAttribute('id', 'viewReg')
        }
      } else {
        this.type1 = 'password'
        const eye = document.getElementById('viewReg');
        if (eye) {
          eye.setAttribute('src', this.viewUrl)
          eye.setAttribute('id', 'no-viewReg')
        }
      } 
    },
    func2() {
      this.show2 = !this.show2
      if (this.show2) {
        this.type2 = 'text'
        const eye = document.getElementById('no-viewRegConf');
        console.log(eye);
        if (eye) {
          eye.setAttribute('src', this.noViewUrl)
          eye.setAttribute('id', 'viewRegConf')
        }
      } else {
        this.type2 = 'password'
        const eye = document.getElementById('viewRegConf');
        if (eye) {
          eye.setAttribute('src', this.viewUrl)
          eye.setAttribute('id', 'no-viewRegConf')
        }
      } 
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
    formReg: {
      loginReg: {
        required,
        minLength: minLength(4),
      },
      nicknameReg: {
        required,
      },
      passwordReg: {
        required,
        minLength: minLength(6),
      },
      passwordConfirm: {
        required,
        sameAsPassword: sameAs("passwordReg"),
      },
    },
  },
};
</script>

<style>
form {
  background-color: rgb(255, 255, 255);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 15px 15px 45px -5px rgba(0, 0, 0, 0.75);
}

.slide-fade-enter-active {
  transition: all 0.5s ease;
}
.slide-fade-enter {
  transform: translateX(20px);
  opacity: 5;
}
.passwordLog {
  position: relative;
}
.password-show {
	position: absolute;
	top: 10px;
	right: 6px;
	display: inline-block;
	width: 20px;
	height: 20px;
}
#view {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
#no-view {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
#viewReg {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
#no-viewReg {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
#viewRegConf {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
#no-viewRegConf {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
</style>

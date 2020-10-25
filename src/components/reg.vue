<template>
    <form @submit.prevent="userRegister" novalidate>
        <!-- Страница регистрации -->
        <div>
            <h2>Регистрация</h2>
            <div v-if="regMessage" class="alert alert-success" role="alert">
            Вы успешно зарегистрировались!
            </div>
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
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formReg.loginReg.$required" class="invalid-feedback">
                {{reqText}}
            </div>
            <!-- сообщение о не прохождении валидации -->
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
            <!-- сообщение о не прохождении валидации -->
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
                <a href="#" class="password-show" v-on:click="func1"><img id="no-view-eye1" src="../images/view.svg"></a>
                </div>
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formReg.passwordReg.$required" class="invalid-feedback">
                {{reqText}}
            </div>
            <!-- сообщение о не прохождении валидации -->
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
            <a href="#" class="password-show" v-on:click="func2"><img id="no-view-eye2" src="../images/view.svg"></a>
            </div>
            <!-- сообщение о не прохождении валидации -->                
            <div class="invalid-feedback" v-if="!$v.formReg.passwordConfirm.$required">
                {{reqText}}
            </div>
            <!-- сообщение о не прохождении валидации -->
            <div v-if="!$v.formReg.passwordConfirm.$sameAs" class="invalid-feedback">
                {{passwordConfirmText}}
            </div>
            </div>

            <button @click="registerUser" :disabled="disabledReg"  type="button" class="btn btn-primary btn-block">Зарегистрироваться</button>
        </div>
    </form>
</template>

<script>
import { required, minLength, sameAs } from "vuelidate/lib/validators";
import { Server } from "../modules/Server.js"

export default {
  data() {
    return {
      reqText: 'Поле обязательно для заполнения',
      minLengthText6: 'Минимальная длина 6 символов!',
      minLengthText4: 'Минимальная длина 4 символов!',
      passwordConfirmText: 'Пароли не совпадают',
      regMessage: false,
      type1: "password",
      type2: "password",
      show1: false,
      show2: false,
      formReg: {
        loginReg: "",
        nicknameReg: "",
        passwordReg: "",
        passwordConfirm: "",
      },
      inputReg: {
        loginReg: "",
        nicknameReg: "",
        passwordReg: "",
        passwordConfirm: "",
      },
      viewUrl: require('../images/view.svg'),
      noViewUrl: require('../images/no-view.svg'),
      Server: new Server()
    };
  },
  computed: {
    // функция отключает кнопку регистрации, если не пройдена валидация
    disabledReg() {
      return (
        this.$v.formReg.nicknameReg.$invalid ||
        this.$v.formReg.loginReg.$invalid ||
        this.$v.formReg.passwordReg.$invalid ||
        this.$v.formReg.passwordConfirm.$invalid
      );
    },
  },
  methods: {
    registerUser() {
      for (let input in this.formReg) {//перенос в отдельный объект
            this.inputReg[input] = this.formReg[input]
      }
      
      console.group()
          console.log('Вы успешно зарегистрированны!')
          console.log('Ваше имя: ' + this.formReg.loginReg)
          console.log('Ваш никнейм: ' + this.formReg.nicknameReg)
          console.log('Ваш пароль: ' + this.formReg.passwordReg)
      console.groupEnd()

      console.log(this.inputReg)

      // не работает
      //console.log(this.Server.registration(this.formReg.nicknameReg, this.formReg.loginReg, this.formReg.passwordReg));
      
      this.reset()
    },
    reset() {
        // сбросить шаг и показать сообщение о регистрации
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
    func1() {
      this.show1 = !this.show1
      if (this.show1) {
        this.type1 = 'text'
        const eye = document.getElementById('no-view-eye1');
        if (eye) {
          eye.setAttribute('src', this.noViewUrl)
          eye.setAttribute('id', 'view-eye1')
        }
      } else {
        this.type1 = 'password'
        const eye = document.getElementById('view-eye1');
        if (eye) {
          eye.setAttribute('src', this.viewUrl)
          eye.setAttribute('id', 'no-view-eye1')
        }
      } 
    },
    func2() {
      this.show2 = !this.show2
      if (this.show2) {
        this.type2 = 'text'
        const eye = document.getElementById('no-view-eye2');
        if (eye) {
          eye.setAttribute('src', this.noViewUrl)
          eye.setAttribute('id', 'view-eye2')
        }
      } else {
        this.type2 = 'password'
        const eye = document.getElementById('view-eye2');
        if (eye) {
          eye.setAttribute('src', this.viewUrl)
          eye.setAttribute('id', 'no-view-eye2')
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

.form-control.is-invalid{
    background-image: none;
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
#view-eye, #no-view-eye, #view-eye1, #no-view-eye1, #view-eye2, #no-view-eye2 {
  width: 100%;
  height: 100%;
  display: block;
  margin: 0 auto;
}
</style>

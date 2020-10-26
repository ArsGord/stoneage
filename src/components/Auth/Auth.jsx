import React from 'react';

class Auth extends React.Component {
    constructor(props) {
        super();
        this.setAuthState = props.setAuthState;

        this.server = props.server;
    }
  
    auth() {
        this.server.login('vasya', '123456');
        this.setAuthState(false);
    }
  
    render() {
      return (
        <div className="auth">
            <div className="input__menu">
                <input className='input__login' id="loginAuth" placeholder="Login" />
                <input type="password" className='input__password' id="passwordAuth" placeholder="Password"  />
            </div>  
            <div className="button__menu">
                <button className='button__sign__in' id="userLogin" onClick={() => this.auth()}>Авторизоваться</button>
            </div>
        </div>
      );
    }
  }
  
  export default Auth;
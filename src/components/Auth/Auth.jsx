import React from 'react';

class Auth extends React.Component {
    constructor(props) {
        super();
        this.setAuthState = props.setAuthState;
        this.setHash = props.setHash;
        this.server = props.server;
    }
  
    async auth() {
        this.setHash(await this.server.login('vasya', '123456'));
        this.setAuthState(false);
    }
  
    render() {
      return (
        <div className="auth">
            <div className="input-menu">
                <input className='input-login' id="loginAuth" placeholder="Login" />
                <input type="password" className='input-password' id="passwordAuth" placeholder="Password"/>
            </div>  
            <div className="button-menu">
                <button className='button-sign-in' id="userLogin" onClick={() => this.auth()}>Авторизоваться</button>
            </div>
        </div>
      );
    }
  }
  
  export default Auth;
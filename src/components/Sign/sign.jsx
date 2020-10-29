import React from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import { LinkContainer } from 'react-router-bootstrap'
import { Button } from 'react-bootstrap';

class Sign extends React.Component {
    constructor(props) {
        super();
        this.setAuthState = props.setAuthState;
        this.setHash = props.setHash;
        this.server = props.server;
    }

    async reg() {
        this.setHash(await this.server.registration(this.nickname.value, this.login.value, this.password.value));
    }
  
    render() {
      return (
        <div className="container mt-5">
            <div className="col-sm-4 mx-auto">
                <form>
                    <div>
                    <h2>Регистрация</h2>
                        <div className="form-group">
                        <label htmlFor="login">Логин</label>
                        <input ref={ref => this.login = ref} type="text" className="form-control mb-2" id="login"/>
                        </div>
    
                        <div className="form-group">
                        <label htmlFor="password">Никнейм</label>
                        <input ref={ref => this.nickname = ref} className="form-control mb-2" id="password"/>
                        </div>

                        <div className="form-group">
                        <label htmlFor="password">Пароль</label>
                        <input ref={ref => this.password = ref} className="form-control mb-2" id="password"/>
                        </div>

                        {/* <div className="form-group">
                        <label htmlFor="password">Подтверждение пароля</label>
                        <input ref={ref => this.password = ref} className="form-control mb-2" id="password"/>
                        </div> */}

                        <div>
                          <LinkContainer to='/game'>
                              <Button type="button" className="btn btn-success btn-block mt-3" onClick={() => this.reg()}>Вход</Button>
                          </LinkContainer>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      );
    }
  }
  
  export default Sign;
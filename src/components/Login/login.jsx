import React from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import { LinkContainer } from 'react-router-bootstrap'
import { Button } from 'react-bootstrap';

class Login extends React.Component {
    constructor(props) {
        super();
        this.setHash = props.setHash;
        this.server = props.server;
    }

    async auth() {
        this.setHash(await this.server.login(this.login.value, this.password.value));
    }
  
    render() {
      return (
        <div>
            <div className="container mt-5">
                <div className="col-sm-4 mx-auto">
                    <form>
                        <div>
                        <h2>Вход</h2>
                            <div className="form-group">
                            <label htmlFor="login">Логин</label>
                            <input type="text" className="form-control mb-2" id="login" ref={ref => this.login = ref}/>
                            </div>
        
                            <div className="form-group">
                            <label htmlFor="password">Пароль</label>
                            <input ref={ref => this.password = ref} className="form-control" id="password"/>
                            </div>

                            <LinkContainer to='/game'>
                                <Button type="button" className="btn btn-success btn-block mt-3" onClick={() => this.auth()}>Вход</Button>
                            </LinkContainer>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
      );
    }
}

export default Login;
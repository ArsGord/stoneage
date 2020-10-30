import React from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import './style.css'
import { LinkContainer } from 'react-router-bootstrap'
import { Button } from 'react-bootstrap';
import ViewSvg from '../../images/view.svg'
import noViewSvg from '../../images/no-view.svg'

class Sign extends React.Component {
    constructor(props) {
        super();
        this.setHash = props.setHash;
        this.server = props.server;
        this.state = {
            image: ViewSvg
        }
    }

    async reg() {
        this.setHash(await this.server.registration(this.nickname.value, this.login.value, this.password.value));
    }

    changeView() {
        if (this.password.type === 'password') {
            this.password.setAttribute('type', 'text');
            this.setState({image: noViewSvg});
        } else {
            this.password.setAttribute('type', 'password');
            this.setState({image: ViewSvg});
        }
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
                        <div className="passwordLog">
                            <input ref={ref => this.password = ref} className="form-control mb-2" id="password" type="password"/>  
                            <a href="#" className="password-show" onClick={() => this.changeView()}><img id="view-eye" src={this.state.image}/></a>  
                        </div>
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
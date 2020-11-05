import React from 'react';
//import { LinkContainer } from 'react-router-bootstrap';
import { Button } from 'react-bootstrap';
import { Redirect } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.css';
import './style.css';
import ViewSvg from '../../images/view.svg';
import noViewSvg from '../../images/no-view.svg';

class Login extends React.Component {
    constructor(props) {
        super();
        this.setHash = props.setHash;
        this.server = props.server;
        this.state = {
            image: ViewSvg,
            disabled: true,
            hash: ''
        }
    }

    async auth() {
        this.setHash(await this.server.login(this.login.value, this.password.value));
        if (localStorage.getItem('token') === 'false') {
            this.setState({hash: ''});
        } else {
            this.setState({hash: localStorage.getItem('token')});
        }
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

    handleChange = (e) => {
        if(this.login.value && this.password.value) {
            this.setState({
                disabled: false,
            });
        } else {
            this.setState({
                disabled: true
            })
        }
    }
  
    render() {
        if (this.state.hash) {
            return <Redirect to='/game'/>
        } else {
            return (
                <div>
                    <div className="container mt-5">
                        <div className="col-sm-4 mx-auto">
                            <form>
                                <div>
                                <h2>Вход</h2>

                                    <div className="form-group">
                                        <label htmlFor="login">Логин</label>
                                        <input type="text" 
                                            className="form-control mb-2"
                                            id="login" 
                                            ref={ref => this.login = ref}
                                            onChange={ this.handleChange }
                                            />
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="password">Пароль</label>
                                        <div className="passwordLog">
                                            <input ref={ref => this.password = ref}
                                                className="form-control" 
                                                id="password" 
                                                type="password"
                                                onChange={ this.handleChange }
                                            />
                                            {/* eslint-disable-next-line */}
                                            <a href="#" className="password-show" onClick={() => this.changeView()}><img id="view-eye" src={this.state.image}/></a>
                                        </div>
                                    </div>
                                    <Button disabled={ this.state.disabled } type="button" className="btn btn-success btn-block mt-3" onClick={() => this.auth()}>Вход</Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            );
        }
    }
}

export default Login;
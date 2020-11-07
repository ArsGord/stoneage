import React from 'react';
import { Redirect } from 'react-router';
import 'bootstrap/dist/css/bootstrap.css';
import './style.css';
//import { LinkContainer } from 'react-router-bootstrap';
import { Button } from 'react-bootstrap';
import ViewSvg from '../../images/view.svg';
import noViewSvg from '../../images/no-view.svg';

class Sign extends React.Component {
    constructor(props) {
        super();
        this.server = props.server;
        this.state = {
            image: ViewSvg,
            disabled: true,
            canRedirect: false
        }
    }

    async reg() {
        const result = await this.server.registration(this.nickname.value, this.login.value, this.password.value);
        if (result) {
            this.setState({canRedirect: result});
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
        if(this.login.value && this.password.value && this.nickname.value) {
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
        if (this.state.canRedirect) {
            return <Redirect to='/game'/>
        } else {
            return (
                <div className="container mt-5">
                    <div className="col-sm-4 mx-auto">
                        <form>
                            <div>
                            <h2>Регистрация</h2>
                                <div className="form-group">
                                    <label htmlFor="login">Логин</label>
                                        <input ref={ref => this.login = ref}
                                            type="text"
                                            className="form-control mb-2" 
                                            id="login"
                                            onChange={ this.handleChange }
                                        />
                                </div>
            
                                <div className="form-group">
                                    <label htmlFor="nickname">Никнейм</label>
                                        <input ref={ref => this.nickname = ref} 
                                            className="form-control mb-2"
                                            id="nickname"
                                            onChange={ this.handleChange }
                                        />
                                </div>

                                <div className="form-group">
                                    <label htmlFor="password">Пароль</label>
                                        <div className="passwordLog">
                                            <input ref={ref => this.password = ref} 
                                                    className="form-control mb-2" 
                                                    id="password" 
                                                    type="password"
                                                    onChange={ this.handleChange }
                                                    />  
                                                {/* eslint-disable-next-line */}
                                                <a href="#" className="password-show" onClick={() => this.changeView()}><img id="view-eye" src={this.state.image}/></a> 
                                        </div>
                                </div>
                                <div>
                                <Button disabled={ this.state.disabled } type="button" className="btn btn-success btn-block mt-3" onClick={() => this.reg()}>Вход</Button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            );
        }
    }
}
  
export default Sign;
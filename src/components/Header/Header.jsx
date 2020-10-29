import React from 'react';
import { LinkContainer } from 'react-router-bootstrap'
import { Button } from 'react-bootstrap';


class Header extends React.Component {
    render() {
        return (
            <div className="navbar" >
                <div className="h2">Stone Age</div>
                <div>
                <LinkContainer to="/login">
                    <Button type="button" className="btn btn-success my-2 my-sm-0" >Вход</Button>
                </LinkContainer>
                <LinkContainer to="/registration">
                    <Button type="button" className="btn btn-primary mr-2 ml-2 my-2 my-sm-0">Регистрация</Button>
                </LinkContainer>
                </div>
            </div>
        )
    }
}

export default Header;
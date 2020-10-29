import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { NavLink } from "react-router-dom"

class Game extends React.Component {
    constructor(props) {
        super();
        this.setAuthState = props.setAuthState;
        this.state = {
          hash: props.hash
        }
    }
  
    render() {
      return (
          <div>
            <div>Это игра!!!</div>
            <p>Ваш хеш: {this.state.hash}</p>
            <NavLink to='/login'>Логаут</NavLink>
          </div>
      );
    }
  }
  
  export default Game;
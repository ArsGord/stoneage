import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { NavLink } from "react-router-dom"

class Game extends React.Component {
    constructor(props) {
        super(props);
        this.updateHash = props.updateHash;
        this.hash = this.props.hash;
    }
  
    render() {
      return (
          <div>
            <div>Это игра!!!</div>
            <p>Ваш хеш: {this.props.hash}</p>
            <NavLink to='/login'>Логаут</NavLink>
          </div>
      );
    }
  }
  
  export default Game;
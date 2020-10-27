import React from 'react';

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
            <button onClick={() => this.setAuthState(true)}>Логаут</button>
          </div>
      );
    }
  }
  
  export default Game;
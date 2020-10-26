import React from 'react';

class Game extends React.Component {
    constructor(props) {
        super();
        this.setAuthState = props.setAuthState;
    }
  
    render() {
      return (
          <div>
            <div>Это игра!!!</div>
            <button onClick={() => this.setAuthState(true)}>Логаут</button>
          </div>
      );
    }
  }
  
  export default Game;
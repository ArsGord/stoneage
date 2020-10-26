import React from 'react';
import './App.css';

import Server from './modules/Server';

import Auth from './components/Auth';
import Game from './components/Game';

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      auth: true
    }
    this.server = new Server();
  }

  setAuthState(auth) {
    this.setState({ auth });
  }

  render() {
    return (
      <div className="App">
        { this.state.auth ?
          <Auth server={this.server} setAuthState = {(val) => this.setAuthState(val)}/> :
          <Game setAuthState = {(val) => this.setAuthState(val)}/>
        }
      </div>
    );  
  }
}

export default App;
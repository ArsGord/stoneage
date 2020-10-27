import React from 'react';
import './App.css';

import Server from './modules/Server.js';

import Auth from './components/Auth';
import Game from './components/Game';

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      auth: true,
      hash: ''
    }
    this.server = new Server();
  }

  setAuthState(auth) {
    this.setState({ auth });
  }

  setHash(hash) {
    this.setState({ hash });
  }

  render() {
    return (
      <div className="App">
        { this.state.auth ?
          <Auth server={this.server} setAuthState = {(val) => this.setAuthState(val)} setHash = {(hash) => this.setHash(hash)}/> :
          <Game setAuthState = {(val) => this.setAuthState(val)} hash = {this.state.hash}/>
        }
      </div>
    );  
  }
}

export default App;
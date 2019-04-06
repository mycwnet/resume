import React from 'react';
import ReactDOM from 'react-dom';
import Main from './main';


const main = document.getElementById('react-app');

if (main) {
  try {
    ReactDOM.render(<Main />, main);
  } catch (error) {
    console.error(error);
  }
}

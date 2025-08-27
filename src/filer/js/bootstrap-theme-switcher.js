/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2022 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 * Original from: https://getbootstrap.com/docs/5.3/assets/js/color-modes.js 
 */

(() => {
    'use strict'
  
    // Migrate and remove legacy key 'theme'
    (function migrateLegacy(){
      const legacy = localStorage.getItem('theme');
      if (legacy && !localStorage.getItem('dkrr-theme')) {
        localStorage.setItem('dkrr-theme', legacy);
      }
      if (legacy) localStorage.removeItem('theme');
    })();

    const storedTheme = localStorage.getItem('dkrr-theme');
  
    const getPreferredTheme = () => {
      if (storedTheme) {
        return storedTheme
      }
  
      return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark'
    }
  
    const setTheme = function (theme) {
      if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: light)').matches) {
        document.documentElement.setAttribute('data-bs-theme', 'light')
      } else if (theme === 'auto') { 
        document.documentElement.setAttribute('data-bs-theme', 'dark')
      } else {
        document.documentElement.setAttribute('data-bs-theme', theme)
      }
      // Persist only in new key
      localStorage.setItem('dkrr-theme', theme)
    }
  
    setTheme(getPreferredTheme())
  
    const showActiveTheme = theme => {
      const activeThemeIcon = document.querySelector('.theme-icon-active use')
      const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
      const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')
  
      document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
        element.classList.remove('active')
      })
  
      btnToActive.classList.add('active')
      activeThemeIcon.setAttribute('href', svgOfActiveBtn)
    }
  
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
      const currentStored = localStorage.getItem('dkrr-theme') || 'auto'
      if (currentStored === 'auto') {
        setTheme(getPreferredTheme())
        showActiveTheme(getPreferredTheme())
      }
    })
  
    window.addEventListener('DOMContentLoaded', () => {
      showActiveTheme(getPreferredTheme())
  
      document.querySelectorAll('[data-bs-theme-value]').forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value')
          setTheme(theme)
          showActiveTheme(theme)
        })
      })
    })
    
  })()
/**
 * Bootstrap Scrollspy Fix
 * Ensures scrollspy works correctly when scrolling both up and down
 */
(function() {
  'use strict';
  
  // Wait for DOM to be ready
  document.addEventListener('DOMContentLoaded', function() {
    
    // Check if scrollspy nav exists
    const scrollSpyNav = document.querySelector('#navbar-scrollspy');
    if (!scrollSpyNav) {
      console.log('Scrollspy nav not found');
      return;
    }
    
    // Get all section links
    const navLinks = scrollSpyNav.querySelectorAll('.nav-link');
    const sections = [];
    
    // Build sections array
    navLinks.forEach(link => {
      const href = link.getAttribute('href');
      if (href && href.startsWith('#')) {
        const sectionId = href.substring(1);
        const section = document.getElementById(sectionId);
        if (section) {
          sections.push({
            id: sectionId,
            element: section,
            link: link
          });
        }
      }
    });
    
    if (sections.length === 0) {
      console.log('No sections found');
      return;
    }
    
    // Create Intersection Observer
    const observerOptions = {
      root: null, // viewport
      rootMargin: '-20% 0px -70% 0px', // Trigger when section is 20% from top
      threshold: [0, 0.1, 0.5, 1]
    };
    
    let currentActive = null;
    
    const observer = new IntersectionObserver((entries) => {
      // Find the most visible section
      let mostVisible = null;
      let maxRatio = 0;
      
      entries.forEach(entry => {
        if (entry.isIntersecting && entry.intersectionRatio > maxRatio) {
          maxRatio = entry.intersectionRatio;
          mostVisible = entry.target;
        }
      });
      
      // If we found a visible section, activate it
      if (mostVisible) {
        const sectionId = mostVisible.getAttribute('id');
        activateLink(sectionId);
      } else {
        // Fallback: use scroll position
        updateActiveByScroll();
      }
    }, observerOptions);
    
    // Observe all sections
    sections.forEach(section => {
      observer.observe(section.element);
    });
    
    // Function to activate a link
    function activateLink(sectionId) {
      if (currentActive === sectionId) {
        return; // Already active
      }
      
      // Remove all active classes
      navLinks.forEach(link => link.classList.remove('active'));
      
      // Find and activate the correct link
      const section = sections.find(s => s.id === sectionId);
      if (section) {
        section.link.classList.add('active');
        currentActive = sectionId;
        console.log('Activated:', sectionId);
      }
    }
    
    // Fallback: Update active link based on scroll position
    function updateActiveByScroll() {
      const scrollPos = window.scrollY + 150; // Offset from top
      
      // Find the current section
      for (let i = sections.length - 1; i >= 0; i--) {
        const section = sections[i];
        const rect = section.element.getBoundingClientRect();
        const offsetTop = rect.top + window.scrollY;
        
        if (scrollPos >= offsetTop) {
          activateLink(section.id);
          return;
        }
      }
      
      // If we're at the top, activate first section
      if (window.scrollY < 100 && sections.length > 0) {
        activateLink(sections[0].id);
      }
    }
    
    // Throttle scroll events
    let scrollTimeout = null;
    window.addEventListener('scroll', function() {
      if (scrollTimeout) {
        clearTimeout(scrollTimeout);
      }
      scrollTimeout = setTimeout(updateActiveByScroll, 100);
    }, { passive: true });
    
    // Initial update
    setTimeout(updateActiveByScroll, 100);
    
    console.log('Custom scrollspy initialized with', sections.length, 'sections');
  });
})();

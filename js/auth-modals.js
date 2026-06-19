document.addEventListener("DOMContentLoaded", function () {
    // Register Modal Elements
    const registerModal = document.getElementById("registerModal");
    const registerOpenBtn = document.getElementById("joinUsBtn");
    const registerCloseBtn = document.getElementById("closeJoinModal");
    const joinForm = document.getElementById("joinForm");

    // Open/Close Modal Functions
    function openRegisterModal() {
        if (registerModal) {
            registerModal.style.display = "flex";
            document.body.style.overflow = "hidden";
            document.documentElement.style.overflow = "hidden";
            
            // Reset form when opening modal
            if (joinForm) {
                joinForm.reset();
                const errorDiv = document.querySelector('.register-error');
                if (errorDiv) errorDiv.remove();
            }
        }
    }

    function closeRegisterModal() {
        if (registerModal) {
            registerModal.style.display = "none";
            document.body.style.overflow = "auto";
            document.documentElement.style.overflow = "auto";
        }
    }

    // Form Submission Handler
    if (joinForm) {
        joinForm.addEventListener("submit", async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Success - redirect to login
                    window.location.href = result.redirect;
                } else {
                    // Clear only problematic fields
                    if (result.clearFields && result.clearFields.length) {
                        result.clearFields.forEach(field => {
                            const input = joinForm.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.value = '';
                                input.focus(); // Focus first cleared field
                            }
                        });
                    }
                    
                    // Show error message
                    let errorDiv = document.querySelector('.register-error');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'register-error';
                        joinForm.insertBefore(errorDiv, joinForm.firstChild);
                    }
                    errorDiv.textContent = result.error;
                    
                    // Scroll to error smoothly
                    errorDiv.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });

                    // shake animation to error
                    errorDiv.classList.add('shake');
                    setTimeout(() => {
                        errorDiv.classList.remove('shake');
                    }, 500);
                }
            } catch (error) {
                console.error('Registration error:', error);
                // Fallback error handling
                alert('An unexpected error occurred. Please try again later.');
            } finally {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    }

    // Event Listeners
    if (registerOpenBtn) {
        registerOpenBtn.addEventListener("click", (e) => {
            e.preventDefault();
            openRegisterModal();
        });
    }

    if (registerCloseBtn) {
        registerCloseBtn.addEventListener("click", (e) => {
            e.preventDefault();
            closeRegisterModal();
        });
    }

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target === registerModal) {
            closeRegisterModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && registerModal.style.display === "flex") {
            closeRegisterModal();
        }
    });

    // Prevent form submission on Enter key in inputs
    if (joinForm) {
        const inputs = joinForm.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                    e.preventDefault();
                }
            });
        });
    }
});

// CSS for shake animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .shake {
        animation: shake 0.5s ease-in-out;
    }
`;
document.head.appendChild(style);

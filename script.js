function showMessage(message) {
  const messageElement = document.querySelector("[data-message]");
  messageElement.classList.toggle("hidden");
  messageElement.textContent = message;
}

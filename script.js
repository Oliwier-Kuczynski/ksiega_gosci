function showMessage(message) {
  const messageElement = document.querySelector("[data-message-element]");
  const blurElement = document.querySelector("[data-info-blur]");
  messageElement.classList.toggle("hidden");
  blurElement.classList.toggle("hidden");
  messageElement.querySelector("p").textContent = message;
}

function deletePost(id) {
  fetch(`functions.php?id=${id}`, {
    method: "DELETE",
  }).then((_res) => {
    location.reload();
  });
}

function openEdit(element) {
  const id = element.parentElement.parentElement.dataset.id;
  const name = element.parentElement.parentElement.dataset.name;
  const email = element.parentElement.parentElement.dataset.email;
  const message = element.parentElement.parentElement.dataset.message;

  const editElement = document.querySelector("[data-edit-post]");
  const blurElement = document.querySelector("[data-info-blur]");

  editElement.querySelector("#id").value = id;
  editElement.querySelector("#name").value = name;
  editElement.querySelector("#email").value = email;
  editElement.querySelector("#message").value = message;

  editElement.classList.toggle("hidden");
  blurElement.classList.toggle("hidden");
}

function closeInfo(element) {
  const infoElement = element.parentElement;
  const blurElement = document.querySelector("[data-info-blur]");

  infoElement.classList.add("hidden");
  blurElement.classList.add("hidden");
}

// function editPost(id, name, email, message) {
//   fetch(
//     `functions.php?id=${id}&name=${name}&email=${email}&message=${message}`,
//     {
//       method: "PUT",
//     }
//   ).then((_res) => {
//     window.location.href = "index.php";
//   });
// }

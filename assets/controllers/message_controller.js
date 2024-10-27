import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  initialize() {
    this.showMessage();
    setTimeout(() => {
      this.hideMessage();
    }, 2500); // Adjust the time (5000ms = 5 seconds) as needed
  }

  showMessage() {
    this.element.classList.remove("opacity-0");
    this.element.classList.add("opacity-100");
  }

  hideMessage() {
    this.element.classList.remove("opacity-100");
    this.element.classList.add("opacity-0");
    setTimeout(() => {
      this.deleteMessage();
    }, 100);
  }
  deleteMessage() {
    this.element.classList.add("hidden");
  }
}

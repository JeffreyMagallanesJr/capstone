document.addEventListener("DOMContentLoaded", () => {
    const boardsContainer = document.getElementById("boards-container");
    const addBoardBtn = document.getElementById("add-board-btn");

    // Load data from localStorage
    let boards = JSON.parse(localStorage.getItem("boards")) || [];

    const saveBoards = () => {
        localStorage.setItem("boards", JSON.stringify(boards));
    };

    const renderBoards = () => {
        boardsContainer.innerHTML = "";
        boards.forEach((board, boardIndex) => {
            const boardElement = document.createElement("div");
            boardElement.className = "board";

            const title = document.createElement("div");
            title.className = "board-title";
            title.innerText = board.title;

            // Add delete button to board title
            const deleteBoardBtn = document.createElement("button");
            deleteBoardBtn.innerText = "Delete";
            deleteBoardBtn.className = "delete-board-btn";
            deleteBoardBtn.addEventListener("click", () => {
                if (confirm("Are you sure you want to delete this board?")) {
                    boards.splice(boardIndex, 1);
                    saveBoards();
                    renderBoards();
                }
            });
            title.appendChild(deleteBoardBtn);

            // Columns Container
            const columnsContainer = document.createElement("div");
            columnsContainer.className = "columns-container";

            board.columns.forEach((column, columnIndex) => {
                const columnElement = document.createElement("div");
                columnElement.className = "column";

                // Column Title
                const columnTitle = document.createElement("div");
                columnTitle.className = "column-title";
                columnTitle.innerText = column.title;
                columnElement.appendChild(columnTitle);

                // Cards
                column.cards.forEach((card, cardIndex) => {
                    const cardElement = document.createElement("div");
                    cardElement.className = "card";
                    cardElement.innerText = card;

                    // Add delete button to card
                    const deleteCardBtn = document.createElement("button");
                    deleteCardBtn.innerText = "Delete";
                    deleteCardBtn.className = "delete-card-btn";
                    deleteCardBtn.addEventListener("click", () => {
                        if (confirm("Are you sure you want to delete this card?")) {
                            board.columns[columnIndex].cards.splice(cardIndex, 1);
                            saveBoards();
                            renderBoards();
                        }
                    });
                    cardElement.appendChild(deleteCardBtn);

                    // Enable drag-and-drop
                    cardElement.draggable = true;
                    cardElement.addEventListener("dragstart", (e) => {
                        e.dataTransfer.setData(
                            "text/plain",
                            JSON.stringify({ boardIndex, columnIndex, cardIndex })
                        );
                    });

                    // Add click event to view card details
                    cardElement.addEventListener("click", () => {
                        // Open the modal with the card content
                        openCardModal(boardIndex, columnIndex, cardIndex);
                    });

                    columnElement.appendChild(cardElement);
                });

                // Drop area
                columnElement.addEventListener("dragover", (e) => {
                    e.preventDefault();
                });

                columnElement.addEventListener("drop", (e) => {
                    e.preventDefault();
                    const { boardIndex: fromBoardIndex, columnIndex: fromColumnIndex, cardIndex: fromCardIndex } =
                        JSON.parse(e.dataTransfer.getData("text/plain"));

                    const [movedCard] = boards[fromBoardIndex].columns[
                        fromColumnIndex
                    ].cards.splice(fromCardIndex, 1);

                    boards[boardIndex].columns[columnIndex].cards.push(movedCard);
                    saveBoards();
                    renderBoards();
                });

                // Add card button
                const addCardButton = document.createElement("div");
                addCardButton.className = "add-item";
                addCardButton.innerText = "+ Add Card";
                addCardButton.addEventListener("click", () => {
                    const textarea = document.createElement("textarea");
                    textarea.placeholder = "Enter card text...";
                    textarea.rows = 4; // Define the number of rows visible by default
                    textarea.cols = 30; // Define the width of the textarea
                    textarea.style.color = "black";

                    // Save the card when "Enter" is pressed
                    textarea.addEventListener("keydown", (e) => {
                        if (e.key === "Enter" && !e.shiftKey) {  // Shift + Enter allows new line, Enter saves the card
                            e.preventDefault();  // Prevent the default Enter behavior
                            const cardText = textarea.value.trim();
                            if (cardText) {
                                boards[boardIndex].columns[columnIndex].cards.push(cardText);
                                saveBoards();
                                renderBoards();
                            }
                        }
                    });

                    // Append the textarea and focus it
                    addCardButton.replaceWith(textarea);
                    textarea.focus();
                });

                columnElement.appendChild(addCardButton);
                columnsContainer.appendChild(columnElement);
            });

            boardElement.appendChild(title);
            boardElement.appendChild(columnsContainer);
            boardsContainer.appendChild(boardElement);
        });
    };

    addBoardBtn.addEventListener("click", () => {
        const boardTitle = prompt("Enter board title:");
        if (boardTitle) {
            boards.push({ title: boardTitle, columns: [{ title: "", cards: [] }] });
            saveBoards();
            renderBoards();
        }
    });

    renderBoards();

    // Modal setup for viewing card content
    const modal = document.createElement("div");
    modal.id = "card-modal";
    modal.className = "modal";
    modal.innerHTML = `
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h3 id="modal-card-title"></h3>
            <p id="modal-card-content"></p>
        </div>
    `;
    document.body.appendChild(modal);

    // Close modal event
    document.getElementById("close-modal").addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Open modal with card details
    function openCardModal(boardIndex, columnIndex, cardIndex) {
        const cardText = boards[boardIndex].columns[columnIndex].cards[cardIndex];
        document.getElementById("modal-card-title").innerText = ``;
        document.getElementById("modal-card-content").innerText = cardText;
        modal.style.display = "block";
    }

    // Close modal if clicked outside
    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});

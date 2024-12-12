// Function to handle ticket form submission
document.getElementById('ticket-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const customerName = document.getElementById('customer-name').value;
    const ticketSubject = document.getElementById('ticket-subject').value;
    const ticketMessage = document.getElementById('ticket-message').value;
    const ticketStatus = document.getElementById('ticket-status').value;

    $.ajax({
        type: "POST",
        url: 'Services/AddTicketService.php',
        data: { customerName, ticketSubject, ticketMessage, ticketStatus },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Ticket submitted successfully!');
                loadTickets();
            } else {
                alert('Failed to submit ticket.');
            }
        }
    });
});

// Function to load submitted tickets
function loadTickets() {
    $.ajax({
        type: "GET",
        url: 'Services/GetTicketsService.php',
        success: function(response) {
            const tickets = JSON.parse(response);
            const ticketsTable = document.querySelector('#submitted-tickets tbody');
            ticketsTable.innerHTML = '';
            tickets.forEach(ticket => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${ticket.ticketID}</td>
                    <td>${ticket.customerName}</td>
                    <td>${ticket.subject}</td>
                    <td>${ticket.status}</td>
                    <td>
                        <button class="btn btn-primary" onclick="updateTicketStatus('${ticket.ticketID}', 'in-progress')">In Progress</button>
                        <button class="btn btn-success" onclick="updateTicketStatus('${ticket.ticketID}', 'closed')">Close</button>
                    </td>
                `;
                ticketsTable.appendChild(row);
            });
        }
    });
}

// Function to update ticket status
function updateTicketStatus(ticketID, status) {
    $.ajax({
        type: "POST",
        url: 'Services/UpdateTicketStatusService.php',
        data: { ticketID, status },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Ticket status updated successfully!');
                loadTickets();
            } else {
                alert('Failed to update ticket status.');
            }
        }
    });
}

// Load tickets on page load
window.onload = loadTickets;
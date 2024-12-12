$(document).ready(function() {
    loadUserTickets();
});

function loadUserTickets() {
    $.ajax({
        type: "GET",
        url: 'Services/GetUserTicketsService.php',
        success: function(response) {
            const tickets = JSON.parse(response);
            const container = $('.new-bg-container');
            container.empty();

            tickets.forEach(ticket => {
                const ticketElement = `
                    <div class="ticket-item">
                        <div class="ticket-info">
                            <div class="left-info">
                                <span class="ticket-id">Ticket ID: ${ticket.TicketID}</span>
                                <span class="subject">Subject: ${ticket.subject}</span>
                            </div>
                            <div class="right-info">
                                <span class="date">Date Submitted: ${new Date(ticket.date_submitted).toLocaleDateString()}</span>
                                <span class="status">Status: ${ticket.ticket_status}</span>
                            </div>
                        </div>
                    </div>
                `;
                container.append(ticketElement);
            });

            // Add the "Submit a Ticket" button at the end
            const submitButton = `<a href="SubmitATicket.php" class="submit-ticket-button">Submit a Ticket</a>`;
            container.append(submitButton);
        }
    });
}
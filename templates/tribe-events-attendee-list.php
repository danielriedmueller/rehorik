<?php if (current_user_can(PERMISSION_VIEW_VIEW_ATTENDEE_LIST)): ?>
    <?php $attendees = tribe_tickets_get_attendees( get_the_ID()); ?>
    <div class="rehorik-tribe-events-attendee-list">
        <h2>Teilnehmerliste</h2>
        <?php if(sizeof($attendees) > 0): ?>
            <div class="table-outer">
                <table>
                    <thead>
                    <tr>
                    <tr>
                        <th>Ticket</th>
                        <th>Bestellstatus</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Telefon</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendees as $attendee) {
                            echo sprintf(
                                '<tr><td>%s</td><td>%s</td><td>%s</td><td><a href="mailto:%s">%s</a></td><td>%s</td></tr>',
                                $attendee['ticket'],
                                $attendee['order_status_label'],
                                $attendee['holder_name'],
                                $attendee['holder_email'],
                                $attendee['holder_email'],
                                isset($attendee['attendee_meta']['telefon']) ? $attendee['attendee_meta']['telefon']['value'] : "/",
                            );
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Es sind noch keine Teilnehmer angemeldet.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
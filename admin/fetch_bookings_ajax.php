<?php
include('db.php');

$query = "SELECT bookings.id, bookings.status, bookings.booking_date, bookings.checkin_date, 
                 users.full_name, users.email, packages.p_name 
          FROM bookings 
          JOIN users ON bookings.user_id = users.id 
          JOIN packages ON bookings.package_id = packages.id 
          ORDER BY bookings.id DESC";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $status = $row['status'];
        $statusBadge = match($status) {
            'Confirmed' => "bg-green-100 text-green-700 border-green-200",
            'Cancelled' => "bg-red-100 text-red-700 border-red-200",
            default => "bg-yellow-100 text-yellow-700 border-yellow-200"
        };
?>
<tr class="hover:bg-indigo-50/30 transition duration-200">
    <td class="p-4">
        <div class="font-bold text-indigo-600">#BK-<?php echo $row['id']; ?></div>
        <div class="font-semibold text-gray-800"><?php echo $row['full_name']; ?></div>
    </td>
    <td class="p-4 hidden md:table-cell font-medium text-gray-600">
        <?php echo $row['p_name']; ?>
    </td>
    <td class="p-4 hidden sm:table-cell">
        <div class="text-xs space-y-1">
            <div class="flex items-center text-gray-700 font-medium">
                <i class="far fa-calendar-alt mr-2 text-indigo-400"></i>
                Booked: <?php echo date('d M', strtotime($row['booking_date'])); ?>
            </div>
            <div class="flex items-center text-indigo-600 font-bold">
                <i class="fas fa-plane-departure mr-2"></i>
                Travel: <?php echo date('d M, Y', strtotime($row['checkin_date'])); ?>
            </div>
        </div>
    </td>
    <td class="p-4">
        <span class="px-3 py-1 rounded-lg text-[11px] font-black border <?php echo $statusBadge; ?>">
            <?php echo strtoupper($status); ?>
        </span>
    </td>
    <td class="p-4">
        <div class="flex flex-col md:flex-row justify-center gap-2">
            <?php if($status != 'Confirmed'): ?>
                <a href="bookings.php?id=<?php echo $row['id']; ?>&status=Confirmed" 
                   class="text-center bg-emerald-500 text-white py-1.5 px-3 rounded-lg text-xs font-bold hover:bg-emerald-600 shadow-sm transition">
                   Approve
                </a>
            <?php endif; ?>

            <?php if($status != 'Cancelled'): ?>
                <button onclick="confirmCancel(<?php echo $row['id']; ?>)" 
                        class="bg-rose-500 text-white py-1.5 px-3 rounded-lg text-xs font-bold hover:bg-rose-600 shadow-sm transition">
                        Cancel
                </button>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php 
    }
} else {
    echo "<tr><td colspan='5' class='p-20 text-center text-gray-400'>No bookings found.</td></tr>";
}
?>
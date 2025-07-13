<?php 
    while($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output .= '<div class="flex justify-between my-4">
                <div class="flex gap-4">
                    <div class="relative">
                      <img class="w-13 h-13 rounded object-cover" src="profile-pic/'. $user['profile-pic'] .'" alt="">
                      <div class="absolute w-3 h-3 bg-green-500 rounded-full border-2 border-white" style="right: -5px; bottom:15px"></div>
                    </div>
                    <div style="width: 380px">
                        <strong>'. $user['last-name'] .' '.$user['first-name'].'</strong>
                        <p class="text-gray-600">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Praesentium omnis voluptatem quam ipsum!</p>
                    </div>
                </div>
                <div class="flex gap-2 flex-col items-center">
                    <p class="text-gray-600">12:35</p>
                    <p class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">2</p>
                </div>
            </div>';
    }

?>
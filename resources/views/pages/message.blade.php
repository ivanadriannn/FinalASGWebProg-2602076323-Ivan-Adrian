@extends('layouts.master')

@section('content')
    <style>
        .scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        .friend-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .friend-container img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-box {
            height: 75vh;
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 15px;
            position: relative;
        }

        .message {
            display: flex;
            margin-bottom: 15px;
        }

        .message.outgoing {
            justify-content: flex-end;
        }

        .message.incoming {
            justify-content: flex-start;
        }

        .message-box {
            background-color: #f1f1f1;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .message.outgoing .message-box {
            background-color: #d4edda;
            border-radius: 15px 15px 0 15px;
        }

        .message.incoming .message-box {
            background-color: #e7e7e7;
            border-radius: 15px 15px 15px 0;
        }

        .message-time {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
            display: block;
            text-align: right;
        }

        .message-input-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .friend-list {
            overflow-y: auto;
            height: calc(90vh - 20px);
        }

        .friend-list a {
            text-decoration: none;
        }
    </style>

    <div class="container-fluid mx-auto d-flex" style="max-width: 1200px; min-height: 90vh;">
        <div class="w-25 p-3 border-end">
            <div class="friend-list">
                @foreach ($friends as $friend)
                    <a href="javascript:void(0)" class="text-decoration-none text-black friend-link"
                        data-id="{{ $friend->user_id == auth()->user()->id ? $friend->friend->id : $friend->user->id }}"
                        data-img="{{ $friend->user_id == auth()->user()->id
                            ? ($friend->friend->profile_image
                                ? 'data:image/jpeg;base64,' . base64_encode($friend->friend->profile_image)
                                : asset('assets/img/profile.png'))
                            : ($friend->user->profile_image
                                ? 'data:image/jpeg;base64,' . base64_encode($friend->user->profile_image)
                                : asset('assets/img/profile.png')) }}">
                        <div class="friend-container">
                            <img src="{{ $friend->user_id == auth()->user()->id
                                ? ($friend->friend->profile_image
                                    ? 'data:image/jpeg;base64,' . base64_encode($friend->friend->profile_image)
                                    : asset('assets/img/profile.png'))
                                : ($friend->user->profile_image
                                    ? 'data:image/jpeg;base64,' . base64_encode($friend->user->profile_image)
                                    : asset('assets/img/profile.png')) }}"
                                alt="Profile Image" class="friend-profile-img">
                            <p class="mb-0">
                                {{ $friend->user_id == auth()->user()->id ? $friend->friend->name : $friend->user->name }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="w-75 p-3">
            <div id="chat-box" class="chat-box scrollbar-hidden">
                <p class="text-muted text-center">@lang('lang.select_chat')</p>
            </div>

            <form id="send-message-form" method="POST" class="message-input-container">
                @csrf
                <input type="text" name="content" id="message-content" class="form-control me-2" placeholder="@lang('lang.type_message')" required>
                <button type="submit" class="btn btn-primary">@lang('lang.btn_send')</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chatBox = document.getElementById('chat-box');
            const sendMessageForm = document.getElementById('send-message-form');
            const messageContentInput = document.getElementById('message-content');
            let currentFriendId = null;

            const startPollingProfilePictures = () => {
                setInterval(() => {
                    fetch('/friends/update-profile-images')
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(friend => {
                                const friendLink = document.querySelector(`.friend-link[data-id="${friend.id}"]`);
                                if (friendLink) {
                                    const friendImg = friendLink.querySelector('.friend-profile-img');
                                    if (friendImg.src !== friend.image) {
                                        friendImg.src = friend.image;
                                    }
                                }
                            });
                        })
                        .catch(console.error);
                }, 5000); // Setiap 5 detik
            };

            startPollingProfilePictures();

            document.querySelectorAll('.friend-link').forEach(link => {
                link.addEventListener('click', function () {
                    const friendId = this.getAttribute('data-id');
                    currentFriendId = friendId;
                    sendMessageForm.action = `/messages/${friendId}`;
                    chatBox.innerHTML = '<p class="text-muted text-center">Loading messages...</p>';

                    fetch(`/messages/${friendId}`)
                        .then(response => response.json())
                        .then(data => {
                            chatBox.innerHTML = '';
                            if (data.messages.length > 0) {
                                data.messages.forEach(message => {
                                    const alignment = message.sender_id === {{ auth()->user()->id }} ? 'outgoing' : 'incoming';
                                    chatBox.innerHTML += `
                                        <div class="message ${alignment}">
                                            <div class="message-box">
                                                <p>${message.content}</p>
                                                <span class="message-time">${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                            </div>
                                        </div>
                                    `;
                                });
                            } else {
                                chatBox.innerHTML = '<p class="text-muted text-center">@lang('lang.no_messages')</p>';
                            }
                            chatBox.scrollTop = chatBox.scrollHeight;
                        })
                        .catch(console.error);
                });
            });

            sendMessageForm.addEventListener('submit', event => {
                event.preventDefault();

                if (!currentFriendId) {
                    alert('Please select a friend to chat with.');
                    return;
                }

                const content = messageContentInput.value.trim();
                if (!content) return;

                fetch(`/messages/${currentFriendId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content })
                })
                    .then(response => response.json())
                    .then(data => {
                        const newMessage = data.messages[data.messages.length - 1];
                        const alignment = newMessage.sender_id === {{ auth()->user()->id }} ? 'outgoing' : 'incoming';
                        chatBox.innerHTML += `
                            <div class="message ${alignment}">
                                <div class="message-box">
                                    <p>${newMessage.content}</p>
                                    <span class="message-time">${new Date(newMessage.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                </div>
                            </div>
                        `;
                        chatBox.scrollTop = chatBox.scrollHeight;
                        messageContentInput.value = '';
                    })
                    .catch(console.error);
            });
        });
    </script>
@endsection

@extends('admin.loyout.master')
@section('content')

  <style>
    /* subtle scroll for member list */
    #memberListContainer::-webkit-scrollbar {
      width: 5px;
    }
    #memberListContainer::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 10px;
    }
    #memberListContainer::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 10px;
    }
    #memberListContainer::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
    .member-enter {
      animation: fadeSlide 0.2s ease-out;
    }
    @keyframes fadeSlide {
      0% { opacity: 0; transform: translateY(-6px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>

  <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200/70 transition-all">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
      <div class="bg-indigo-100 p-2.5 rounded-xl text-indigo-600">
        <i class="fas fa-door-open text-xl"></i>
      </div>
      <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Create new room</h2>
      <span class="ml-auto text-xs bg-slate-200 text-slate-600 px-3 py-1 rounded-full font-medium">members side</span>
    </div>

    <!-- Main form + side member area (flex) -->
    <div class="flex flex-col md:flex-row gap-6">

      <!-- LEFT: main form fields -->
      <div class="flex-1 space-y-5">
        <!-- Room Name -->
        <div>
          <label for="roomName" class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-tag text-indigo-400 mr-1.5"></i> Room name
          </label>
          <input type="text" id="roomName" placeholder="e.g. Design Sprint, Gaming Lobby..."
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800 placeholder:text-slate-400">
        </div>

        <!-- Room Type -->
        <div>
          <label for="roomType" class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-layer-group text-indigo-400 mr-1.5"></i> Room type
          </label>
          <select id="roomType"
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800">
            <option value="public">🌐 Public</option>
            <option value="private" selected>🔒 Private</option>
            <option value="team">👥 Team</option>
            <option value="channel">📢 Channel</option>
          </select>
        </div>

        <!-- Submit & reset (placed here on mobile, will be below on desktop) -->
        <div class="flex flex-col sm:flex-row gap-3 pt-1">
          <button type="submit" id="createRoomBtn"
                  class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <i class="fas fa-check-circle"></i> Create room
          </button>
          <button type="reset" id="resetFormBtn"
                  class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2.5 rounded-xl transition flex items-center justify-center gap-2">
            <i class="fas fa-undo-alt"></i> Reset
          </button>
        </div>

        <!-- feedback message -->
        <div id="formFeedback" class="text-sm font-medium text-center transition-all duration-200 h-6"></div>
      </div>

      <!-- RIGHT: Member side panel (add form + listing) -->
      <div class="md:w-64 lg:w-72 bg-slate-50/80 rounded-xl border border-slate-200 p-4 flex flex-col">
        <div class="flex items-center justify-between mb-3">
          <h3 class="font-semibold text-slate-700 text-sm flex items-center gap-1.5">
            <i class="fas fa-user-friends text-indigo-500"></i> Members
            <span id="memberCounter" class="ml-1 bg-indigo-100 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-bold">0</span>
          </h3>
          <button id="clearMembersBtn" type="button" class="text-xs text-slate-400 hover:text-red-500 transition" title="Clear all members">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>

        <!-- Add member form (inline) -->
        <div class="flex gap-1.5 mb-3">
          <input type="text" id="memberInput" placeholder="Name..."
                 class="flex-1 px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 outline-none text-sm bg-white">
          <button id="addMemberSideBtn"
                  class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg transition text-sm flex items-center gap-1 shadow-sm">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>

        <!-- Member listing (scrollable) -->
        <div id="memberListContainer" class="flex-1 max-h-52 overflow-y-auto pr-1 space-y-1.5">
          <!-- empty state -->
          <div id="emptyMemberMsg" class="text-xs text-slate-400 italic flex items-center justify-center py-4 bg-white rounded-lg border border-dashed border-slate-300">
            <i class="fas fa-user-plus mr-1.5 text-slate-300"></i> No members yet
          </div>
          <!-- dynamic member items will be injected here -->
        </div>

        <!-- small hint -->
        <div class="mt-2 text-[10px] text-slate-400 flex items-center gap-1">
          <i class="fas fa-info-circle"></i> click ✕ to remove
        </div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      "use strict";

      // ----- DOM refs -----
      const memberInput = document.getElementById('memberInput');
      const addMemberBtn = document.getElementById('addMemberSideBtn');
      const memberListContainer = document.getElementById('memberListContainer');
      const emptyMsg = document.getElementById('emptyMemberMsg');
      const memberCounter = document.getElementById('memberCounter');
      const clearMembersBtn = document.getElementById('clearMembersBtn');

      // main form elements
      const roomNameInput = document.getElementById('roomName');
      const roomTypeSelect = document.getElementById('roomType');
      const createRoomBtn = document.getElementById('createRoomBtn');
      const resetFormBtn = document.getElementById('resetFormBtn');
      const feedback = document.getElementById('formFeedback');

      // ----- state -----
      let members = [];

      // ----- render function (builds list from members array) -----
      function renderMembers() {
        // remove all .member-item rows (keep emptyMsg)
        const items = memberListContainer.querySelectorAll('.member-item');
        items.forEach(el => el.remove());

        // update counter
        memberCounter.textContent = members.length;

        // toggle empty message
        if (members.length === 0) {
          emptyMsg.style.display = 'flex';
        } else {
          emptyMsg.style.display = 'none';
        }

        // render each member
        members.forEach((memberName, index) => {
          const row = document.createElement('div');
          row.className = 'member-item flex items-center justify-between bg-white border border-slate-200 rounded-lg px-3 py-1.5 shadow-sm member-enter';

          // left: avatar + name
          const leftDiv = document.createElement('div');
          leftDiv.className = 'flex items-center gap-2 truncate';

          const avatar = document.createElement('div');
          avatar.className = 'w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold';
          const initial = memberName.trim().charAt(0).toUpperCase() || '?';
          avatar.textContent = initial;

          const nameSpan = document.createElement('span');
          nameSpan.className = 'text-slate-700 text-sm font-medium truncate';
          nameSpan.textContent = memberName || 'Unnamed';

          leftDiv.appendChild(avatar);
          leftDiv.appendChild(nameSpan);

          // right: remove button
          const removeBtn = document.createElement('button');
          removeBtn.type = 'button';
          removeBtn.className = 'text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-full p-0.5 transition';
          removeBtn.innerHTML = '<i class="fas fa-times-circle text-base"></i>';
          removeBtn.setAttribute('aria-label', 'Remove member');

          removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            members.splice(index, 1);
            renderMembers();
            // clear feedback if any
            feedback.textContent = '';
            feedback.className = 'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
          });

          row.appendChild(leftDiv);
          row.appendChild(removeBtn);

          // insert before emptyMsg (which stays in the container)
          memberListContainer.insertBefore(row, emptyMsg);
        });
      }

      // ----- add member from side input -----
      function addMemberFromInput() {
        const raw = memberInput.value;
        const trimmed = raw.trim();
        if (trimmed === '') {
          // short feedback on the side (or main feedback)
          feedback.textContent = '⚠️ Please enter a member name.';
          feedback.className = 'mt-3 text-sm font-medium text-center text-amber-600 transition-all duration-200 h-6';
          memberInput.focus();
          return;
        }
        // add to members
        members.push(trimmed);
        renderMembers();
        // clear input
        memberInput.value = '';
        memberInput.focus();
        // clear feedback
        feedback.textContent = '';
        feedback.className = 'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
      }

      // ----- clear all members -----
      function clearAllMembers() {
        if (members.length === 0) return;
        members = [];
        renderMembers();
        feedback.textContent = '';
        feedback.className = 'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
      }

      // ----- event listeners -----
      // Add button click
      addMemberBtn.addEventListener('click', addMemberFromInput);

      // Enter key on input
      memberInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          addMemberFromInput();
        }
      });

      // Clear all members
      clearMembersBtn.addEventListener('click', clearAllMembers);

      // ----- Form submit (Create room) -----
      createRoomBtn.addEventListener('click', function(e) {
        e.preventDefault(); // we are not using form submit, but button click

        const roomName = roomNameInput.value.trim();
        const roomType = roomTypeSelect.value;

        if (!roomName) {
          feedback.textContent = '❌ Please enter a room name.';
          feedback.className = 'mt-3 text-sm font-medium text-center text-red-500 transition-all duration-200 h-6';
          return;
        }

        // build members summary
        const memberNames = members.length > 0 ? members.join(', ') : 'No members';

        feedback.innerHTML = `✅ Room "<strong>${roomName}</strong>" created! Type: ${roomType} · Members: ${members.length}`;
        feedback.className = 'mt-3 text-sm font-medium text-center text-emerald-600 transition-all duration-200 h-6';

        console.log('Room created:', { roomName, roomType, members: members.slice() });
      });

      // ----- Reset (clear all fields and members) -----
      resetFormBtn.addEventListener('click', function(e) {
        e.preventDefault();
        // reset room fields
        roomNameInput.value = '';
        roomTypeSelect.value = 'private';
        // clear members
        members = [];
        renderMembers();
        // clear feedback
        feedback.textContent = '';
        feedback.className = 'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
        // focus room name
        roomNameInput.focus();
      });

      // (optional) click on empty message or anywhere else to focus input? no.

      // initial render
      renderMembers();

      // small demo: focus input on load
      memberInput.focus();

      // Extra: if user clicks on the member list container, focus input (nice)
      memberListContainer.addEventListener('click', function() {
        memberInput.focus();
      });

    })();
  </script>

@endsection

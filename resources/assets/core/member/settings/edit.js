import React from 'react';
import ReactDOM from 'react-dom';

$(function () {
  $('.__xe_settingEmail').click(function () {
    $('.__xe_emailView').slideToggle();
    $('#__xe_emailSetting').slideToggle();
  });
});

$(function () {
  var EmailBox = React.createClass({
    componentDidMount: function () {
      this.loadCommentsFromServer();
    },

    getInitialState: function () {
      return { mails: [], selected: this.props.email };
    },

    loadCommentsFromServer: function () {
      $.ajax({
        url: this.props.url.mail.list,
        type: 'get',
        dataType: 'json',
        data: { userId: this.props.userId },
        context: this,
        success: function (result) {
          this.setState({ mails: result.mails });
        },

        error: function (result) {
          XE.toast('danger', '오류!.', '.__xe_alertEmailModal');
        },
      });
    },

    handleChange: function (address) {
      this.setState($.extend(this.state, { selected: address }));
    },

    handleAddEmail: function (email) {
      $.ajax({
        url: this.props.url.mail.add,
        type: 'post',
        dataType: 'json',
        data: { userId: this.props.userId, address: email.address },
        context: this,
        success: function (result) {
          var mails = this.state.mails;
          mails[mails.length] = result.mail;
          this.setState({ mails: mails });
          XE.toast('success', '추가되었습니다.', '.__xe_alertEmailModal');
        },

        error: function (result) {
          XE.toast('danger', result.responseJSON.message, '.__xe_alertEmailModal');
        },
      });
    },

    handleDeleteEmail: function (email) {

      $.ajax({
        url: this.props.url.mail.delete,
        type: 'post',
        dataType: 'json',
        data: { userId: this.props.userId, address: email.address },
        context: this,
        success: function (result) {
          var i = this.state.mails.indexOf(email);
          this.state.mails.splice(i, 1);
          this.setState(this.state.mails);
          XE.toast('success', '삭제하였습니다.', '.__xe_alertEmailModal');
        },

        error: function (result) {
          XE.toast('danger', result.responseJSON.message, '.__xe_alertEmailModal');
        },
      });
    },

    render: function () {
      return (
        React.createElement('div', null,
          React.createElement(EmailList, {
          box: this,
          selected: this.state.selected,
          selectedOrigin: this.props.email,
          mails: this.state.mails,
          onChange: this.handleChange,
          onDeleteEmail: this.handleDeleteEmail,
        }),
          React.createElement(EmailInserter, { onAddEmail: this.handleAddEmail })
        )
      );
    },
  });
  var EmailList = React.createClass({
    handleChange: function (address) {
      this.props.onChange(address);
    },

    render: function () {
      var mails = this.props.mails;
      var selected = this.props.selected;
      var selectedOrigin = this.props.selectedOrigin;
      var _this = this;
      var selectedItem = null;
      var lists = mails.map(function (mail, i) {
        var item = (
          React.createElement(EmailItem, {
          box: _this.props.box,
          seq: i,
          isSelected: mail.address == selected,
          isSelectedOrigin: mail.address == selectedOrigin,
          mail: mail,
          onChange: _this.handleChange,
          onDeleteEmail: _this.props.onDeleteEmail,
        })
        );
        if (mail.address != selected) {
          return item;
        } else {
          selectedItem = item;
        }
      });

      return (
        React.createElement('ul', { className: 'list-group' }, selectedItem, lists)
      );
    },
  });
  var EmailItem = React.createClass({
    componentDidMount: function () {
      this.$deleteBtn = $(ReactDOM.findDOMNode(this.refs.deleteBtn));
      this.$deleteConfirmBtn = $(ReactDOM.findDOMNode(this.refs.deleteConfirmBtn));
      this.$deleteCancelBtn = $(ReactDOM.findDOMNode(this.refs.deleteCancelBtn));
    },

    handleChange: function (e) {
      this.props.onChange(this.props.mail.address);
    },

    handleDelete: function () {
      this.$deleteBtn.hide();
      this.$deleteConfirmBtn.show();
      this.$deleteCancelBtn.show();
    },

    handleDeleteConfirm: function () {
      this.props.onDeleteEmail(this.props.mail);
    },

    handleDeleteCancel: function () {
      this.$deleteBtn.show();
      this.$deleteConfirmBtn.hide();
      this.$deleteCancelBtn.hide();
    },

    render: function () {
      var mail = this.props.mail;

      var deleteBtns = null;

      if (!this.props.isSelectedOrigin) {
        deleteBtns =
          React.createElement('span', { className: 'pull-right' },
            React.createElement('a', {
            ref: 'deleteBtn',
            href: '#',
            className: 'btn btn-sm btn-link',
            onClick: this.handleDelete,
          }, '삭제'),
            React.createElement('a', {
            ref: 'deleteConfirmBtn',
            href: '#',
            style: { display: 'none' },
            className: 'btn btn-sm btn-link',
            onClick: this.handleDeleteConfirm,
          }, '삭제확인'),
            React.createElement('a', {
            ref: 'deleteCancelBtn',
            href: '#',
            style: { display: 'none' },
            className: 'btn btn-sm btn-link',
            onClick: this.handleDeleteCancel,
          }, '취소')
          );
      }

      return (
        React.createElement('li', { className: 'list-group-item clearfix' },
          React.createElement('label', null,
            React.createElement('input', {
            type: 'radio',
            ref: 'input',
            onChange: this.handleChange,
            name: 'email',
            value: mail.address,
            checked: this.props.isSelected,
          }),
            ' ' + mail.address
          ),
          deleteBtns
        )
      );
    },
  });
  var EmailInserter = React.createClass({
    handleClick: function (e) {
      e.preventDefault();
      var $input = $(ReactDOM.findDOMNode(this.refs.input));
      var email = $input.val();
      if (!email) {
        return;
      }

      $input.val('');
      this.props.onAddEmail({ address: email });
    },

    render: function () {
      return (
        React.createElement('div', {
          className: 'input-group input-group-sm',
          style: { marginBottom: '20px' },
        },
          React.createElement('input', {
          type: 'text',
          className: 'form-control',
          id: '__xe_addedEmailInput',
          ref: 'input',
          placeholder: '이메일을 입력하세요',
        }),
          React.createElement('span', { className: 'input-group-btn' },
            React.createElement('buttion', {
            id: '__xe_emailAddBtn',
            className: 'btn btn-default',
            type: 'button',
            onClick: this.handleClick,
            ref: 'btn',
          }, '추가')
          )
        )
      );
    },
  });

  var $box = $('#__xe_emailSetting');
  ReactDOM.render(
    React.createElement(EmailBox, {
    url: url,
    userId: $box.data('userId'),
    email: $box.data('email'),
  }),
    $box.get(0)
  );

});
